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
        $query = "insert into `test`.`USER` (email, password, name) values (?, ?, ?) except select email, password, name from `test`.`USER`";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $email, $password, $name);
        $result = $stmt->execute();
        return $result;
    }

    public function checkLogin(string $email, string $password)
    {
        $query = "SELECT * FROM USER WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function checkUserType(string $email)
    {
        $query = "SELECT isSeller FROM USER WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
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
