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
        $stmt = $this->db->prepare(
            "SELECT name, details, size, basePrice, image 
             FROM ARTICLE 
             ORDER BY RAND()
             LIMIT ?"
        );
        $stmt->bind_param("i", $amount);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
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
        $query = "insert into `test`.`USER` (email, password, name) select ?, ?, ? where not exists (select email from `test`.`USER` where email = ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssss', $email, $password, $name, $email);
        $result = $stmt->execute();
        return $result;
    }

    public function isLoginValid(string $email, string $password)
    {
        $query = "SELECT * FROM USER WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        if(count($result) == 0){
            return false;
        }
        return true;
    }

    public function checkUserType(string $email)
    {
        $query = "SELECT email FROM USER WHERE email in (select email from SELLER)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        if(count($result) == 0){
            return "client";
        }

        return "seller";
    }

    public function getNotifications(string $email)
    {
        $query = "SELECT content FROM NOTIFICATION WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

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
