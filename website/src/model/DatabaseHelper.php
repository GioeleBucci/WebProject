<?php
class DatabaseHelper
{
    private static $instance = null;
    private $db;



    /*** Helper-related functions ***/

    private function __construct($servername, $username, $password, $dbname, $port)
    {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self(Settings::DB_SERVERNAME, Settings::DB_USERNAME, Settings::DB_PASSWORD, Settings::DB_DBNAME, Settings::DB_PORT);
        }
        return self::$instance;
    }

    private function __clone()
    {
        // Prevent cloning
    }

    public function __wakeup()
    {
        throw new Exception("Unserialization of this class is not allowed.");
    }



    /*** Category functions ***/

    public function getCategoryNames()
    {
        $result = $this->db->query("SELECT * FROM CATEGORY");
        return array_column($result->fetch_all(MYSQLI_ASSOC), 'name');
    }



    /*** Article functions ***/

    public function getArticles(int $amount)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM ARTICLE ORDER BY RAND() LIMIT ?"
        );
        $stmt->bind_param("i", $amount);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getArticle(int $articleId)
    {
        $stmt = $this->db->prepare("SELECT * FROM ARTICLE WHERE articleId=?");
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /** Get all available versions for a specific article */
    public function getAllVersions(int $articleId){
        $stmt = $this->db->prepare("SELECT * FROM ARTICLE_VERSION WHERE articleId=?");
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns a merged table of the article and its version, with a "price" field 
     * containing the total price of the product.
     */
    public function getArticleVersion(int $articleId, int $versionId)
    {
        $stmt = $this->db->prepare(
            "SELECT a.*, v.*, (a.basePrice + v.priceVariation) AS price 
            FROM ARTICLE a
            JOIN ARTICLE_VERSION v ON a.articleId = v.articleId
            WHERE a.articleId = ? AND v.versionId = ?"
        );
        $stmt->bind_param("ii", $articleId, $versionId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }



    /*** Order functions ***/
    
    public function addOrder(string $email, string $date, string $notes)
    {
        $query = "INSERT INTO `test`.`CLIENT_ORDER` (email, orderDate, notes) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $email, $date, $content);
        $result = $stmt->execute();
        $this->addNotification($email, "", "Ordine effettuato");
        return $result;
    }

    public function getOrders(int $clientId)
    {
        $stmt = $this->db->prepare("SELECT * FROM CLIENT_ORDER WHERE userId=?");
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }



    /*** Cart functions ***/

    public function getCartItems(int $clientId)
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.amount
            FROM (SELECT a.image, a.name, a.details, v.articleId, v.versionId, v.versionType, (a.basePrice + v.priceVariation) AS price 
                FROM ARTICLE a
                JOIN ARTICLE_VERSION v ON a.articleId = v.articleId) p
            JOIN SHOPPING_CART_ITEM c ON p.articleId = c.articleId AND p.versionId = c.versionId
            WHERE c.userId = ?");
        $stmt->bind_param("i", $clientId);

        return $stmt->execute() ? $stmt->get_result()->fetch_all(MYSQLI_ASSOC) : null;
    }

    public function isInCart(int $userId, int $articleId, int $versionId)
    {
        $query = "SELECT amount FROM SHOPPING_CART_ITEM WHERE userId = ? AND articleId = ? AND versionId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $userId, $articleId, $versionId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
        return intval($result);
    }

    public function addToCart(int $userId, int $articleId, int $versionId) {
        $amount = $this->isInCart($userId, $articleId, $versionId);
        
        if ($amount != 0) {
            $amount += 1;
            $query = "UPDATE SHOPPING_CART_ITEM SET amount = ? WHERE userId = ? AND articleId = ? AND versionId = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("iiii", $amount, $userId, $articleId, $versionId);
        }
        else {
            $query = "INSERT INTO SHOPPING_CART_ITEM VALUES (?, ?, ?, 1)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("iii", $userId, $articleId, $versionId);
        }
        
        if ($stmt->execute()) {
            return true;
        }
        else {
            return false;
        }
    }

    public function removeFromCart(int $userId, int $articleId, int $versionId)
    {
        $query = "DELETE FROM SHOPPING_CART_ITEM WHERE userId = ? AND articleId = ? AND versionId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $userId, $articleId, $versionId);
        if ($stmt->execute()) {
            return true;
        }
        else {
            return false;
        }
    }
    
    public function emptyCart(int $userId)
    {
        $query = "DELETE FROM SHOPPING_CART_ITEM WHERE userId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $userId, $articleId, $versionId);
        if ($stmt->execute()) {
            return true;
        }
        else {
            return false;
        }
    }


    /*** Wishlist functions ***/

    public function getWishlistItems(int $userId)
    {
        $stmt = $this->db->prepare(
            "SELECT a.* 
            FROM ARTICLE a
            JOIN WISHLIST w ON a.articleId = w.articleId
            WHERE w.userId = ?");
        $stmt->bind_param("i", $userId);

        return $stmt->execute() ? $stmt->get_result()->fetch_all(MYSQLI_ASSOC) : null;
    }

    public function isInWishlist(int $userId, int $articleId)
    {
        $query = "SELECT COUNT(*) as count FROM WISHLIST WHERE userId = ? AND articleId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $userId, $articleId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        return $result['count'] > 0;
    }

    public function addToWishlist(int $userId, int $articleId) 
    {
        if ($this->isInWishlist($userId, $articleId)) {
            return true; // Already in wishlist
        }
        
        $query = "INSERT INTO WISHLIST VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $userId, $articleId);
        
        return $stmt->execute();
    }

    public function removeFromWishlist(int $userId, int $articleId)
    {
        $query = "DELETE FROM WISHLIST WHERE userId = ? AND articleId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $userId, $articleId);
        
        return $stmt->execute();
    }


    /*** User functions ***/

    public function getUserId(string $email)
    {
        $query = "SELECT userId FROM `test`.`USER` WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        if ($stmt->execute()) {
            $result = intval($stmt->get_result()->fetch_assoc()['userId']);
        } else {
            $result = null;
        }
        return $result;
    }

    /**
     * Adds a new user to the database if one with his credentials
     * is not already present.
     * @return array Returns the result of the query if successful,
     * and an empty string otherwise.
     */
    public function addUser(string $email, string $password, string $name)
    {
        if ($this->getUserId($email) != null) {
            $result["errCode"] = "ALR_EXIST";
            $result["result"] = false;
        } else {
            $query = "INSERT INTO `test`.`USER` (email, password, name) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sss', $email, $password, $name);
            $check = $stmt->execute();
            if ($check == true) {
                $result["result"] = true;
            } else {
                $result["errCode"] = "FATAL";
                $result["result"] = false;
            }
        }

        return $result;
    }

    public function isLoginValid(string $email, string $password)
    {
        $query = "SELECT userId FROM `test`.`USER` WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        if (count($result) == 1) {
            return true;
        }
        return false;
    }

    public function checkUserType(int $userId)
    {
        $query = "SELECT userId FROM USER WHERE userId = ? AND userId in (select userId from SELLER)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        if (count($result) == 1) {
            return "seller";
        }
        return "client";
    }



    /*** Notification functions ***/

    public function getNotifications(int $userId)
    {
        $query = "SELECT * FROM NOTIFICATION WHERE userId = ? ORDER BY receptionTime DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $result;
    }

    public function addNotification(int $userId, string $time, string $content)
    {
        $query = "INSERT INTO `test`.`NOTIFICATION` (userId, receptionTime, content, isRead) VALUES (?, ?, ?, false)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iss', $userId, $time, $content);
        $result = $stmt->execute();
        return $result;
    }



    /*** Search functions ***/

    /**
     * Queries the database for the searched term and/or filter.
     * @return array Returns the result of the query if successful,
     * and an empty string otherwise.
     */
    public function searchBy(string $name = "", string ...$filters)
    {
        $result = [];
        $query = "SELECT * FROM ARTICLE";
        $conditions = [];
        $params = [];
        $types = "";

        if ($name !== "") {
            $conditions[] = "name LIKE ?";
            $params[] = "%" . $name . "%";
            $types .= "s";
        }

        if (!empty($filters)) {
            $conditions[] = "categoryId IN (SELECT categoryId FROM CATEGORY WHERE name IN (" . implode(",", array_fill(0, count($filters), "?")) . "))";
            foreach ($filters as $filter) {
                $params[] = $filter;
                $types .= "s";
            }
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $this->db->prepare($query);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $result;
    }

    

    /*** Payment functions ***/

    public function getPaymentMethodsNames()
    {
        $result = $this->db->query("SELECT name FROM PAYMENT_METHOD");
        return array_column($result->fetch_all(MYSQLI_ASSOC), 'name');
    }

}
