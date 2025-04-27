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
    if (!isset($_POST['articleId'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Article ID not provided']);
        exit;
    }
    
    // Extract data
    $userId = $_SESSION['userId'];
    $articleId = intval($_POST['articleId']);
    
    // Get database helper instance
    $dbh = DatabaseHelper::getInstance();
    
    // Check if item is in WISHLIST
    $isInWishlist = $dbh->isInWishlist($userId, $articleId);
    
    // Toggle WISHLIST status
    if ($isInWishlist) {
        // Remove from WISHLIST
        $success = $dbh->removeFromWishlist($userId, $articleId);
        $status = false;
    } else {
        // Add to WISHLIST
        $success = $dbh->addToWishlist($userId, $articleId);
        $status = true;
    }
    
    // Return success response
    echo json_encode([
        'success' => $success,
        'inWishlist' => $status,
        'articleId' => $articleId
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
