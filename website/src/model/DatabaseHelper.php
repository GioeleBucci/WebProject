<?php

class DatabaseHelper
{
    private static $instance = null;
    private $db;



    /*
     * Helper methods
    */

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



    /*
     * Category methods
    */

    public function getCategoryNames()
    {
        $result = $this->db->query("SELECT name FROM CATEGORY");
        return array_column($result->fetch_all(MYSQLI_ASSOC), "name");
    }

    public function getAllCategories()
    {
        $result = $this->db->query("SELECT * FROM CATEGORY");
        return $result->fetch_all(MYSQLI_ASSOC);
    }



    /*
     * Article methods
    */

    public function addArticle(int $sellerId, string $name, string $details, string $description, string $material, float $weight, float $price, string $size, int $categoryId, string $image)
    {
        $stmt = $this->db->prepare("INSERT INTO ARTICLE (name, details, longDescription, material, weight, basePrice, size, categoryId, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssddsis", $name, $details, $description, $material, $weight, $price, $size, $categoryId, $image);
        $result = $stmt->execute();

        $articleId = $this->db->query("SELECT articleId FROM ARTICLE ORDER BY articleId DESC LIMIT 1")->fetch_column();

        return $result && $this->insertIntoListing($articleId, $sellerId);
    }

    public function updateArticle(int $articleId, string $name, string $details, string $description, string $material, float $weight, float $price, string $size, int $categoryId, string $image)
    {
        return $this->db->query("UPDATE ARTICLE SET name = $name, details = $details, longDescription = $description, material = $material, weight = $weight, basePrice = $price, size = $size, categoryId = $categoryId, image = $image WHERE articleId = $articleId");
    }

    public function getArticle(int $articleId)
    {
        $stmt = $this->db->prepare("SELECT * FROM ARTICLE WHERE articleId=?");
        $stmt->bind_param("i", $articleId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getAllArticles(int $amount)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM ARTICLE ORDER BY RAND() LIMIT ?"
        );
        $stmt->bind_param("i", $amount);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /** Get all available versions for a specific article */
    public function getArticleVersions(int $articleId){
        $stmt = $this->db->prepare("SELECT * FROM ARTICLE_VERSION WHERE articleId=?");
        $stmt->bind_param("i", $articleId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns a merged table of the article and its version, with a "price" field
     * containing the total price of the product.
     */
    public function getVersion(int $articleId, int $versionId)
    {
        $stmt = $this->db->prepare(
            "SELECT a.*, v.*, (a.basePrice + v.priceVariation) AS price
            FROM ARTICLE a
            JOIN ARTICLE_VERSION v ON a.articleId = v.articleId
            WHERE a.articleId = ? AND v.versionId = ?"
        );
        $stmt->bind_param("ii", $articleId, $versionId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    /** Get all available versions for a specific article */
    public function getAllVersions(int $articleId){
        $stmt = $this->db->prepare("SELECT * FROM ARTICLE_VERSION WHERE articleId=?");
        $stmt->bind_param("i", $articleId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }



    /*
     * Listing methods 
    */

    private function insertIntoListing (int $articleId, int $sellerId) {
        return $this->db->query("INSERT INTO LISTING VALUES ('$articleId', '$sellerId')");
    }

    public function getListing (int $sellerId) {
        $stmt = $this->db->prepare("SELECT * FROM ARTICLE WHERE articleId IN (SELECT articleId from LISTING WHERE sellerId = ?)");
        $stmt->bind_param("i", $sellerId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }



    /*
     * Order methods
    */

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

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }



    /*
     * Cart methods
    */

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
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function isInCart(int $userId, int $articleId, int $versionId)
    {
        $query = "SELECT amount FROM SHOPPING_CART_ITEM WHERE userId = ? AND articleId = ? AND versionId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $userId, $articleId, $versionId);
        $stmt->execute();

        return $stmt->get_result()->fetch_column();
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

        return $stmt->execute();
    }

    public function removeFromCart(int $userId, int $articleId, int $versionId)
    {
        $query = "DELETE FROM SHOPPING_CART_ITEM WHERE userId = ? AND articleId = ? AND versionId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $userId, $articleId, $versionId);

        return $stmt->execute();
    }

    public function emptyCart(int $userId)
    {
        $query = "DELETE FROM SHOPPING_CART_ITEM WHERE userId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $userId, $articleId, $versionId);

        return $stmt->execute();
    }

    public function updateCartItemQuantity(int $userId, int $articleId, int $versionId, int $quantity)
    {
        if ($quantity <= 0) {
            // If quantity is 0 or less, remove the item from cart
            return $this->removeFromCart($userId, $articleId, $versionId);
        }
        
        $query = "UPDATE SHOPPING_CART_ITEM SET amount = ? WHERE userId = ? AND articleId = ? AND versionId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iiii", $quantity, $userId, $articleId, $versionId);
        
        return $stmt->execute();
    }



    /*
     * User methods
    */

    public function getUserId(string $email)
    {
        $query = "SELECT userId FROM `test`.`USER` WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        return intval($stmt->get_result()->fetch_assoc()['userId']);
    }

    /**
     * Adds a new user to the database. Shows an error if the
     * chosen credentials have already been used elsewhere.
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

    public function checkCredentials(string $email, string $password)
    {
        $query = "SELECT userId FROM `test`.`USER` WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();

        return empty($stmt->get_result()->fetch_assoc()) ? false : true;
    }

    public function getUserType(int $userId)
    {
        $query = "SELECT userId FROM SELLER WHERE userId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        return empty($stmt->get_result()->fetch_assoc()) ? Utils::CLIENT : Utils::SELLER;
    }

    public function getUserInfo(int $userId)
    {
        $stmt = $this->db->prepare("SELECT userId, name, email, birthDate, address, phoneNumber FROM USER WHERE userId=?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Updates a user's email address
     * @return bool True if successful, false otherwise
     */
    public function updateUserEmail(int $userId, string $newEmail)
    {
        // Check if email already exists for another user
        $stmt = $this->db->prepare("SELECT userId FROM USER WHERE email = ? AND userId != ?");
        $stmt->bind_param("si", $newEmail, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return false; // Email already in use
        }
        
        $stmt = $this->db->prepare("UPDATE USER SET email = ? WHERE userId = ?");
        $stmt->bind_param("si", $newEmail, $userId);
        return $stmt->execute();
    }
    
    /**
     * Updates a user's password
     * @return bool True if successful, false otherwise
     */
    public function updateUserPassword(int $userId, string $newPassword)
    {
        $stmt = $this->db->prepare("UPDATE USER SET password = ? WHERE userId = ?");
        $stmt->bind_param("si", $newPassword, $userId);
        return $stmt->execute();
    }
    
    /**
     * Updates a user's phone number
     * @return bool True if successful, false otherwise
     */
    public function updateUserPhoneNumber(int $userId, string $newPhoneNumber)
    {
        $stmt = $this->db->prepare("UPDATE USER SET phoneNumber = ? WHERE userId = ?");
        $stmt->bind_param("si", $newPhoneNumber, $userId);
        return $stmt->execute();
    }
    
    /**
     * Updates a user's address
     * @return bool True if successful, false otherwise
     */
    public function updateUserAddress(int $userId, string $newAddress)
    {
        $stmt = $this->db->prepare("UPDATE USER SET address = ? WHERE userId = ?");
        $stmt->bind_param("si", $newAddress, $userId);
        return $stmt->execute();
    }

    /*
     * Notification methods
    */

    public function getAllNotifications(int $userId)
    {
        $query = "SELECT * FROM NOTIFICATION WHERE userId = ? ORDER BY receptionTime DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns true if a notification was successfully added,
     * false otherwise.
     */
    public function addNotification(int $userId, string $time, string $content)
    {
        $query = "INSERT INTO `test`.`NOTIFICATION` (userId, receptionTime, content, isRead) VALUES (?, ?, ?, false)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iss', $userId, $time, $content);

        return $stmt->execute();
    }



    /*
     * Search methods
    */

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

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }



    /*
     * Payment methods
    */

    public function getPaymentMethodsNames()
    {
        $result = $this->db->query("SELECT name FROM PAYMENT_METHOD");
        return array_column($result->fetch_all(MYSQLI_ASSOC), 'name');
    }

    /*** Wishlist functions ***/

    /**
     * Checks if an article is in the user's wishlist
     * @return bool True if the article is in the wishlist, false otherwise
     */
    public function isInWishlist(int $userId, int $articleId)
    {
        $stmt = $this->db->prepare("SELECT * FROM WISHLIST WHERE userId = ? AND articleId = ?");
        $stmt->bind_param("ii", $userId, $articleId);
        $stmt->execute();
        $result = $stmt->get_result();
        $isInWishlist = $result->num_rows > 0;        
        return $isInWishlist;
    }

    /**
     * Adds an article to the user's wishlist
     * @return bool True if successful, false otherwise
     */
    public function addToWishlist(int $userId, int $articleId)
    {
        $stmt = $this->db->prepare("INSERT INTO WISHLIST (userId, articleId) VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $articleId);
        return $stmt->execute();        
    }

    /**
     * Removes an article from the user's wishlist
     * 
     * @return bool True if successful, false otherwise
     */
    public function removeFromWishlist(int $userId, int $articleId)
    {
        $stmt = $this->db->prepare("DELETE FROM WISHLIST WHERE userId = ? AND articleId = ?");
        $stmt->bind_param("ii", $userId, $articleId);
        return $stmt->execute();
    }

    /**
     * Gets all items in a user's wishlist
     */
    public function getWishlistItems(int $userId)
    {
        $stmt = $this->db->prepare(
            "SELECT a.* 
            FROM ARTICLE a
            JOIN WISHLIST w ON a.articleId = w.articleId
            WHERE w.userId = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
