<?php
include_once('db.php');
include_once('model.php');

$user_id = isset($_GET['user']) ? (int)$_GET['user'] : null;

if ($user_id) {
    // creating new database connection required in get_user_transactions_balances function
    $conn = get_connect();
    
    // getting requested user balances
    $transactions = get_user_transactions_balances($user_id, $conn);
    
    // returning json response
    if ($transactions) {
        echo json_encode($transactions);
    } else {
        echo json_encode(['error' => 'No transactions found for this user.']);
    }
// error handling
} else {
    echo json_encode(['error' => 'User ID is required.']);
}
?>