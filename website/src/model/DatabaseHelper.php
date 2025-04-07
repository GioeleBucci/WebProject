<?php
class DatabaseHelper
{
    private static $instance = null;
    private $db;

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

    public function getCategories()
    {
        $stmt = $this->db->prepare("SELECT * FROM CATEGORY");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getArticles(int $amount)
    {
        $stmt = $this->db->prepare("SELECT name, details, size, basePrice, image FROM ARTICLE ORDER BY RAND() LIMIT ?"
        );
        $stmt->bind_param("i", $amount);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addOrder(string $email, string $date, string $notes)
    {
        $query = "INSERT INTO `test`.`CLIENT_ORDER` (email, orderDate, notes) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $email, $date, $content);
        $result = $stmt->execute();
        $this->addNotification($email, "Ordine effettuato");
        return $result;
    }

    public function getOrders(int $customer_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM CLIENT_ORDER WHERE email=?");
        $stmt->bind_param("s", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTrackingStatus(int $order_id)
    {
        $stmt = $this->db->prepare("SELECT departure, arrival, lastPosition FROM DELIVERY WHERE orderId=?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addUser(string $email, string $password, string $name)
    {
        $query = "INSERT INTO `test`.`USER` (email, password, name) VALUES (?, ?, ?) WHERE NOT EXISTS (SELECT email FROM `test`.`USER` WHERE email = ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssss', $email, $password, $name, $email);
        $result = $stmt->execute();
        return $result;
    }

    public function getUserId(string $email)
    {
        $query = "SELECT userId FROM `test`.`USER` WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_assoc()['userId'];
        } else {
            $result = null;
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
        if(count($result) == 1){
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
        if(count($result) == 1){
            return "seller";
        }
        return "client";
    }

    public function getNotifications(int $userId)
    {
        $query = "SELECT content FROM NOTIFICATION WHERE userId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $result;
    }

    public function addNotification(int $userId, string $content)
    {
        $query = "INSERT INTO `test`.`NOTIFICATION` (email, content, isRead) VALUES (?, ?, false)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $userId, $content);
        $result = $stmt->execute();
        return $result;
    }
    
    /**
     * Queries the database for the searched term and/or filters.
     * The latters must be compiled into a single string,
     * separated by white space. If absent, returns the entire
     * database content.
     *
     * @return array Returns the result of the query if successful,
     * and an empty string otherwise.
     */
    public function searchBy(string $name, string ...$filters)
    {
        $result = [];
        if($name != "" && !empty($filters)){
            $query = "SELECT * FROM ARTICLE";
            $stmt = $this->db->prepare($query);
            $success = $stmt->execute();
            if ($success) {
                $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            } else {
                $result = [];
            }
        }
        if($name != ""){
            $nameQuery = $this->searchByName($name);
            $result = array_merge($result, $nameQuery);
        }
        if(!empty($filters)){
            $filtersQuery = $this->searchByFilters($filters);
            $result = array_merge($result, $filtersQuery);
        }
        return $result;
    }
    
    private function searchByName($name)
    {
        $query = "SELECT * FROM ARTICLE WHERE name = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $name);
        $success = $stmt->execute();
        if($success){
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        else{
            $result = [];
        }
        return $result;
    }
    
    private function searchByFilters($filters)
    {
        $query = "SELECT * FROM ARTICLE WHERE categoryId IN (SELECT name FROM CATEGORY WHERE name = ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $keyword);
        $result = [];
        foreach($filters as $filter){
            $keyword = $filter;
            if ($stmt->execute()) {
                $result = array_merge($result, $stmt->get_result()->fetch_all(MYSQLI_ASSOC));
            }
        }
        return $result;
    }

    private function __clone()
    {
        // Prevent cloning
    }

    public function __wakeup()
    {
        throw new Exception("Unserialization of this class is not allowed.");
    }
}
