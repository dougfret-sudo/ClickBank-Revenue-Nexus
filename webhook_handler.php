<?php
/**
 * ClickBank Revenue Nexus - Webhook Handler
 * Verified logic for schema.sql compatibility
 */

$secret_key = "YOUR_CLICKBANK_SECRET"; 
$message = json_decode(file_get_contents('php://input'), true);

if (isset($message['secretKey']) && $message['secretKey'] === $secret_key) {
    
    // Connect to your database
    $conn = new mysqli("localhost", "user", "password", "database");

    if ($conn->connect_error) { die("Connection failed"); }

    // Mapping ClickBank fields to your schema.sql columns
    $tx_id      = $conn->real_escape_string($message['receipt']);
    $sku        = $conn->real_escape_string($message['lineItems'][0]['itemNo']);
    $sale_amt   = floatval($message['totalAccountAmount']);
    // Assuming 50% commission for the logic - Adjust as needed
    $commission = $sale_amt * 0.50; 

    // INSERT into the table defined in your schema.sql
    $sql = "INSERT INTO clickbank_nexus_revenue 
            (transaction_id, product_sku, sale_amount, commission_earned, status) 
            VALUES ('$tx_id', '$sku', $sale_amt, $commission, 'verified')";

    if ($conn->query($sql)) {
        echo "Nexus Sync Complete.";
    }
    
    $conn->close();
} else {
    header('HTTP/1.1 403 Forbidden');
    echo "Unauthorized Access.";
}
?>
