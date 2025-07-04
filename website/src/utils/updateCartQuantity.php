<?php
// Start output buffering immediately to prevent any unwanted output
ob_start();

// Set error handling
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Set JSON content type
header('Content-Type: application/json');

// Include the database helper class
require_once dirname(__DIR__) . '/model/DatabaseHelper.php';
require_once dirname(dirname(__DIR__)) . '/config/settings.php';

try {
    // auth check
    if (!isset($_SESSION['userId'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit;
    }
    
    // input validation
    if (!isset($_POST['articleId']) || !isset($_POST['versionId']) || !isset($_POST['quantity'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
        exit;
    }
    
    // Extract data
    $userId = $_SESSION['userId'];
    $articleId = intval($_POST['articleId']);
    $versionId = intval($_POST['versionId']);
    $quantity = intval($_POST['quantity']);
    
    // Get database helper instance
    $dbh = DatabaseHelper::getInstance();
    
    // Update cart quantity
    $success = $dbh->updateCartItemQuantity($userId, $articleId, $versionId, $quantity);
    
    // Calculate new cart total if requested
    $newTotal = null;
    $itemPrice = null;
    
    if (isset($_POST['getTotal']) && $_POST['getTotal'] === 'true') {
        $cartItems = $dbh->getCartItems($userId);
        $subtotal = 0;
        
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['amount'];
            
            // Find the updated item's new price
            if ($item['articleId'] == $articleId && $item['versionId'] == $versionId) {
                $itemPrice = $item['price'] * $item['amount'];
            }
        }
        
        $newTotal = $subtotal;
    }
    
    // Return success response
    echo json_encode([
        'success' => $success,
        'articleId' => $articleId,
        'versionId' => $versionId,
        'quantity' => $quantity,
        'subtotal' => $newTotal,
        'itemPrice' => $itemPrice,
        'total' => $newTotal !== null ? $newTotal : null
    ]);
    
} catch (Exception $e) {
    // Clear output buffer
    ob_clean();
    
    // Return error response
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}

// End output buffering and send response
ob_end_flush();
