<?php

/**
 * Return list of users.
 */
function get_users($conn)
{
    $usersWithTransaction = $conn->query("
        SELECT users.id, users.name FROM users 
        WHERE EXISTS ( SELECT 1 FROM user_accounts JOIN transactions ON user_accounts.id = transactions.account_from 
        OR user_accounts.id = transactions.account_to
        WHERE user_accounts.user_id = users.id
    );");
    $users_list = [];
    foreach ($usersWithTransaction as $user) {
        $users_list[$user['id']] = $user['name'];
    }

    // Uncomment to see available users with transactions
    // var_dump($users_list);

    return $users_list;
}

/**
 * Return transactions balances of given user.
 */
function get_user_transactions_balances($user_id, $conn)
{     
    $query = "
        SELECT 
            strftime('%m', transactions.trdate) AS month,
            SUM(CASE WHEN transactions.account_to IN (
                SELECT id FROM user_accounts WHERE user_id = ?
            ) THEN transactions.amount ELSE 0 END) -
            SUM(CASE WHEN transactions.account_from IN (
                SELECT id FROM user_accounts WHERE user_id = ?
            ) THEN transactions.amount ELSE 0 END) AS balance
        FROM transactions
        WHERE transactions.trdate IS NOT NULL
        GROUP BY strftime('%m', transactions.trdate)
        ORDER BY strftime('%m', transactions.trdate);
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id, $user_id]);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Uncomment to see users balances for each month
    // var_dump($users_list);

    return $result;
}