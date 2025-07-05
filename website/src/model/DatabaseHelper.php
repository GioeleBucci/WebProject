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
    public function getCategoryName(): string
    {
        $result = $this->db->query("SELECT name FROM CATEGORY");
        if ($result === false) {
            return '';
        }
        $row = $result->fetch_assoc();
        return $row ? $row['name'] : '';
    }

    public function getCategoryNames(): array
    {
        $result = $this->db->query("SELECT name FROM CATEGORY");
        return array_column($result->fetch_all(MYSQLI_ASSOC), "name");
    }

    public function getAllCategories(): array
    {
        $result = $this->db->query("SELECT * FROM CATEGORY");
        return $result->fetch_all(MYSQLI_ASSOC);
    }



    /*
     * Article methods
    */

    private function getLatestArticleId(): int
    {
        return $this->db->query("SELECT articleId FROM ARTICLE ORDER BY articleId DESC LIMIT 1")->fetch_column();
    }

    public function addArticle(int $sellerId, string $name, string $details, string $description, string $material, float $weight, float $price, string $size, int $categoryId, string $image): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO ARTICLE (name, details, longDescription, material, weight, basePrice, size, categoryId, image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssssddsis", $name, $details, $description, $material, $weight, $price, $size, $categoryId, $image);
        $result = $stmt->execute();

        return $result && $this->insertIntoListing($this->getLatestArticleId(), $sellerId);
    }

    public function updateArticle(int $articleId, string $name, string $details, string $description, string $material, float $weight, float $price, string $size, int $categoryId, string $image): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE ARTICLE SET name = ?, details = ?, longDescription = ?, material = ?, weight = ?, basePrice = ?, size = ?, categoryId = ?, image = ?
            WHERE articleId = ?"
        );
        $stmt->bind_param("ssssdisisi", $name, $details, $description, $material, $weight, $price, $size, $categoryId, $image, $articleId);

        return $stmt->execute();
    }

    public function getArticle(int $articleId): array|bool
    {
        $stmt = $this->db->prepare("SELECT * FROM ARTICLE WHERE articleId=?");
        $stmt->bind_param("i", $articleId);

        if (!$stmt->execute()) {
            return false;
        }

        return empty($article = $stmt->get_result()->fetch_assoc()) ? false : $article;
    }

    public function getAllArticles(int $amount): array|bool
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM ARTICLE ORDER BY RAND() LIMIT ?"
        );
        $stmt->bind_param("i", $amount);

        if (!$stmt->execute()) {
            return false;
        }

        return empty($articles = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)) ? false : $articles;
    }



    /*
     * Version methods
    */

    public function addVersion(int $articleId, string $type, float $priceVariation, int $amount): bool
    {
        if ($articleId === -1) {
            $articleId = $this->getLatestArticleId();
        }

        $stmt = $this->db->prepare(
            "INSERT INTO ARTICLE_VERSION (versionId, articleId, versionType, priceVariation, stockAmount) 
            SELECT IFNULL(MAX(versionId), 0) + 1, ?, ?, ?, ? 
            FROM ARTICLE_VERSION 
            WHERE articleId = ?"
        );
        $stmt->bind_param("isdii", $articleId, $type, $priceVariation, $amount, $articleId);

        return $stmt->execute();
    }

    /**
     * Returns a merged table of the article and its version, with a "price" field
     * containing the total price of the product.
     */
    public function getVersion(int $articleId, int $versionId): array|bool|null
    {
        $stmt = $this->db->prepare(
            "SELECT a.*, v.*, (a.basePrice + v.priceVariation) AS price
            FROM ARTICLE a
            JOIN ARTICLE_VERSION v ON a.articleId = v.articleId
            WHERE a.articleId = ? AND v.versionId = ?"
        );
        $stmt->bind_param("ii", $articleId, $versionId);

        if (!$stmt->execute()) {
            return false;
        }

        return empty($version = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)) ? false : $version;
    }

    /** Get all available versions for a specific article */
    public function getAllVersions(int $articleId): array|bool
    {
        $stmt = $this->db->prepare("SELECT * FROM ARTICLE_VERSION WHERE articleId=?");
        $stmt->bind_param("i", $articleId);

        if (!$stmt->execute()) {
            return false;
        }

        $result = $stmt->get_result();

        if ($result === false) {
            return false;
        }

        return empty($versions = $result->fetch_all(MYSQLI_ASSOC)) ? false : $versions;
    }



    /*
     * Listing methods 
    */

    private function insertIntoListing(int $articleId, int $sellerId): bool
    {
        $stmt = $this->db->prepare("INSERT INTO LISTING VALUES (?, ?)");
        $stmt->bind_param("ii", $articleId, $sellerId);

        return $stmt->execute();
    }

    public function getListing(int $sellerId): array|bool
    {
        $stmt = $this->db->prepare("SELECT * FROM ARTICLE WHERE articleId IN (SELECT articleId from LISTING WHERE sellerId = ?)");
        $stmt->bind_param("i", $sellerId);

        if (!$stmt->execute()) {
            return false;
        }

        $result = $stmt->get_result();

        if ($result === false) {
            return false;
        }

        return empty($listing = $result->fetch_all(MYSQLI_ASSOC)) ? false : $listing;
    }



    /*
     * Order methods
    */

    private function getLatestOrderId(): int
    {
        return $this->db->query("SELECT orderId FROM CLIENT_ORDER ORDER BY orderId DESC LIMIT 1")->fetch_column();
    }

    private function addOrderItems(int $orderId, array $cartItems): bool
    {
        $stmt = $this->db->prepare("INSERT INTO ORDER_HAS_ARTICLE (orderId, articleId, versionId, amount) VALUES (?, ?, ?, ?)");

        foreach ($cartItems as $item) {
            $stmt->bind_param("iiii", $orderId, $item['articleId'], $item['versionId'], $item['amount']);
            if (!$stmt->execute()) {
                return false;
            }
        }

        return true;
    }

    public function addOrder(int $userId, int $expense, string $date, array $cartItems = [], string $notes = ""): bool
    {
        $query = "INSERT INTO `CLIENT_ORDER` (userId, totalExpense, notes, orderTime) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iiss', $userId, $expense, $notes, $date);

        if (!$stmt->execute()) {
            return false;
        }

        // If cart items are provided, add them to the order
        if (!empty($cartItems)) {
            $orderId = $this->getLatestOrderId();
            return $this->addOrderItems($orderId, $cartItems);
        }

        return true;
    }

    public function getAllOrders(int $clientId): array|bool
    {
        // First get all order IDs for the client
        $stmt = $this->db->prepare("SELECT orderId FROM CLIENT_ORDER WHERE userId = ? ORDER BY orderTime DESC");
        $stmt->bind_param("i", $clientId);

        if (!$stmt->execute()) {
            return false;
        }

        $result = $stmt->get_result();
        if ($result === false) {
            return false;
        }

        $orderIds = $result->fetch_all(MYSQLI_ASSOC);
        if (empty($orderIds)) {
            return false;
        }

        // Get details for each order and group them properly
        $allOrders = [];
        foreach ($orderIds as $orderRow) {
            $orderDetails = $this->getOrderDetails($orderRow['orderId']);
            if ($orderDetails !== false) {
                // Calculate total item count by summing all amounts
                $totalItemCount = array_sum(array_column($orderDetails, 'amount'));

                // Extract order info from first item and group items
                $orderInfo = [
                    'orderId' => $orderDetails[0]['orderId'],
                    'totalExpense' => $orderDetails[0]['totalExpense'],
                    'orderTime' => $orderDetails[0]['orderTime'],
                    'notes' => $orderDetails[0]['notes'],
                    'delivered' => $orderDetails[0]['delivered'],
                    'itemCount' => $totalItemCount,
                    'items' => array_map(function ($item) {
                        return [
                            'articleName' => $item['articleName'],
                            'versionType' => $item['versionType'],
                            'amount' => $item['amount'],
                            'price' => $item['price']
                        ];
                    }, $orderDetails)
                ];
                $allOrders[] = $orderInfo;
            }
        }

        return empty($allOrders) ? false : $allOrders;
    }

    private function getOrderDetails(int $orderId): array|bool
    {
        $stmt = $this->db->prepare(
            "SELECT o.*, a.name as articleName, av.versionType, oha.amount, 
                    (a.basePrice + av.priceVariation) as price
             FROM CLIENT_ORDER o
             JOIN ORDER_HAS_ARTICLE oha ON o.orderId = oha.orderId
             JOIN ARTICLE a ON oha.articleId = a.articleId
             JOIN ARTICLE_VERSION av ON oha.articleId = av.articleId AND oha.versionId = av.versionId
             WHERE o.orderId = ?"
        );
        $stmt->bind_param("i", $orderId);

        if (!$stmt->execute()) {
            return false;
        }

        return empty($orderDetails = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)) ? false : $orderDetails;
    }

    /*
     * Cart methods
    */

    public function getCartItems(int $clientId): array|bool
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.amount
            FROM (SELECT a.image, a.name, a.details, v.articleId, v.versionId, v.versionType, (a.basePrice + v.priceVariation) AS price
                FROM ARTICLE a
                JOIN ARTICLE_VERSION v ON a.articleId = v.articleId) p
            JOIN SHOPPING_CART_ITEM c ON p.articleId = c.articleId AND p.versionId = c.versionId
            WHERE c.userId = ?"
        );
        $stmt->bind_param("i", $clientId);
        $stmt->execute();

        return ($result = $stmt->get_result()) === false ?: $result->fetch_all(MYSQLI_ASSOC);
    }

    public function isInCart(int $userId, int $articleId, int $versionId): bool|int
    {
        $query = "SELECT amount FROM SHOPPING_CART_ITEM WHERE userId = ? AND articleId = ? AND versionId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $userId, $articleId, $versionId);
        $stmt->execute();

        return ($result = $stmt->get_result()) === false ?: $result->fetch_column();
    }

    public function addToCart(int $userId, int $articleId, int $versionId): bool
    {
        $amount = $this->isInCart($userId, $articleId, $versionId);

        if ($amount != 0) {
            $amount += 1;
            $query = "UPDATE SHOPPING_CART_ITEM SET amount = ? WHERE userId = ? AND articleId = ? AND versionId = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("iiii", $amount, $userId, $articleId, $versionId);
        } else {
            $query = "INSERT INTO SHOPPING_CART_ITEM VALUES (?, ?, ?, 1)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("iii", $userId, $articleId, $versionId);
        }

        return $stmt->execute();
    }

    public function removeFromCart(int $userId, int $articleId, int $versionId): bool
    {
        $query = "DELETE FROM SHOPPING_CART_ITEM WHERE userId = ? AND articleId = ? AND versionId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $userId, $articleId, $versionId);

        return $stmt->execute();
    }

    public function emptyCart(int $userId): bool
    {
        $query = "DELETE FROM SHOPPING_CART_ITEM WHERE userId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);

        return $stmt->execute();
    }

    public function updateCartItemQuantity(int $userId, int $articleId, int $versionId, int $quantity): bool
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

    public function getUserId(string $email): bool|int
    {
        $query = "SELECT userId FROM `kiwi`.`USER` WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        return ($result = $stmt->get_result()) === false ?: $result->fetch_column();;
    }

    /**
     * Adds a new user to the database. Shows an error if the
     * chosen credentials have already been used elsewhere.
     * @return array Returns the result of the query if successful,
     * and an empty string otherwise.
     */
    public function addUser(string $email, string $hashedPassword, string $salt, string $name): array
    {
        $alrExists = $this->getUserId($email);
        if ($alrExists !== false) {
            $result["errCode"] = "ALR_EXIST";
            $result["result"] = false;
        } else {
            $query = "INSERT INTO `kiwi`.`USER` (email, password, salt, name) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssss', $email, $hashedPassword, $salt, $name);
            $check = $stmt->execute();
            if ($check === true) {
                $result["result"] = true;
                $userId = $this->getUserId($email);
                $this->db->query("INSERT INTO CLIENT VALUES ($userId, 1)");
            } else {
                $result["errCode"] = "FATAL";
                $result["result"] = false;
            }
        }

        return $result;
    }

    public function checkCredentials(string $email, string $password): bool
    {
        $query = "SELECT password, salt FROM `kiwi`.`USER` WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        if (!$result) {
            return false;
        }

        $salt = $result['salt'];
        $hashedPassword = hash('sha512', $password . $salt);

        // Compare with stored password
        return $hashedPassword === $result['password'];
    }

    public function getUserType(int $userId): string
    {
        $query = "SELECT userId FROM SELLER WHERE userId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        return empty(($result = $stmt->get_result()) === false ?: $result->fetch_assoc()) ? Utils::CLIENT : Utils::SELLER;
    }

    public function getUserInfo(int $userId): array|bool
    {
        $stmt = $this->db->prepare("SELECT userId, name, email, birthDate, address, phoneNumber FROM USER WHERE userId=?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        return ($result = $stmt->get_result()) === false ?: $result->fetch_assoc();
    }

    /**
     * Updates a user's email address
     * @return bool True if successful, false otherwise
     */
    public function updateUserEmail(int $userId, string $newEmail): bool
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
    public function updateUserPassword(int $userId, string $oldPassword, string $newPassword): bool
    {
        if (!$this->checkCredentials($this->getUserInfo($userId)['email'], $oldPassword)) {
            return false; // Old password does not match
        }
        // Generate new salt and hash the password
        $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $hashedPassword = hash('sha512', $newPassword . $salt);
        
        $stmt = $this->db->prepare("UPDATE USER SET password = ?, salt = ? WHERE userId = ?");
        $stmt->bind_param("ssi", $hashedPassword, $salt, $userId);
        return $stmt->execute();
    }

    /**
     * Updates a user's phone number
     * @return bool True if successful, false otherwise
     */
    public function updateUserPhoneNumber(int $userId, string $newPhoneNumber): bool
    {
        $stmt = $this->db->prepare("UPDATE USER SET phoneNumber = ? WHERE userId = ?");
        $stmt->bind_param("si", $newPhoneNumber, $userId);

        return $stmt->execute();
    }

    /**
     * Updates a user's address
     * @return bool True if successful, false otherwise
     */
    public function updateUserAddress(int $userId, string $newAddress): bool
    {
        $stmt = $this->db->prepare("UPDATE USER SET address = ? WHERE userId = ?");
        $stmt->bind_param("si", $newAddress, $userId);

        return $stmt->execute();
    }



    /*
     * Notification methods
    */

    public function getAllNotifications(int $userId): array|bool
    {
        $query = "SELECT * FROM NOTIFICATION WHERE userId = ? ORDER BY receptionTime DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        return ($result = $stmt->get_result()) === false ?: $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns true if a notification was successfully added,
     * false otherwise.
     */
    public function addNotification(int $userId, string $time, string $content): bool
    {
        $query = "INSERT INTO `kiwi`.`NOTIFICATION` (userId, receptionTime, content, isRead) VALUES (?, ?, ?, false)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iss', $userId, $time, $content);

        return $stmt->execute();
    }

    public function deleteNotification(int $notificationId): bool
    {
        $query = "DELETE FROM `kiwi`.`NOTIFICATION` WHERE notificationId = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $notificationId);

        return $stmt->execute();
    }

    public function markNotificationsAsRead(int $userId): bool
    {
        $query = "UPDATE `kiwi`.`NOTIFICATION` SET isRead = true WHERE userId = ? AND isRead = false";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);

        return $stmt->execute();
    }

    /**
     * Returns the count of unread notifications for a user
     * @return int Number of unread notifications
     */
    public function getUnreadNotificationCount(int $userId): int
    {
        $query = "SELECT COUNT(*) FROM NOTIFICATION WHERE userId = ? AND isRead = false";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        return ($result = $stmt->get_result()) === false ? 0 : $result->fetch_column();
    }



    /*
     * Search methods
    */

    /**
     * Queries the database for the searched term and/or filter.
     * @return array Returns the result of the query if successful,
     * and an empty string otherwise.
     */
    public function searchBy(string $name = "", string ...$filters): array|bool
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

        return ($result = $stmt->get_result()) === false ?: $result->fetch_all(MYSQLI_ASSOC);
    }



    /*
     * Payment methods
    */

    public function getPaymentMethodsNames(): array
    {
        $result = $this->db->query("SELECT name FROM PAYMENT_METHOD");

        return array_column($result->fetch_all(MYSQLI_ASSOC), 'name');
    }

    /*** Wishlist functions ***/

    /**
     * Checks if an article is in the user's wishlist
     * @return bool True if the article is in the wishlist, false otherwise
     */
    public function isInWishlist(int $userId, int $articleId): bool
    {
        $stmt = $this->db->prepare("SELECT userId FROM WISHLIST WHERE userId = ? AND articleId = ?");
        $stmt->bind_param("ii", $userId, $articleId);

        if (!$stmt->execute()) {
            return false;
        }

        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    /**
     * Adds an article to the user's wishlist
     * @return bool True if successful, false otherwise
     */
    public function addToWishlist(int $userId, int $articleId): bool
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
    public function removeFromWishlist(int $userId, int $articleId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM WISHLIST WHERE userId = ? AND articleId = ?");
        $stmt->bind_param("ii", $userId, $articleId);

        return $stmt->execute();
    }

    /**
     * Gets all items in a user's wishlist
     */
    public function getWishlistItems(int $userId): array|bool
    {
        $stmt = $this->db->prepare(
            "SELECT a.* 
            FROM ARTICLE a
            JOIN WISHLIST w ON a.articleId = w.articleId
            WHERE w.userId = ?"
        );
        $stmt->bind_param("i", $userId);

        if (!$stmt->execute()) {
            return false;
        }

        $result = $stmt->get_result();

        if ($result === false) {
            return false;
        }

        return empty($wishlist = $result->fetch_all(MYSQLI_ASSOC)) ? false : $wishlist;
    }
}
