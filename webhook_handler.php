<?php
/**
 * ClickBank Revenue Nexus - Webhook Handler
 * Logic: Catch ClickBank INS, Validate Secret, and Insert to SQL.
 */

// 1. The Secret Key (Your .htaccess level security)
$secret_key = "YOUR_CLICKBANK_SECRET"; 

// 2. Catch the Incoming Data
$message = json_decode(file_get_contents('php://input'));

// 3. Validation Logic (The "Sudo" Check)
if ($message->secretKey == $secret_key) {
    
    // Connect to your SQL Nexus
    $conn = new mysqli("localhost", "user", "password", "database");

    // Map the Particulars
    $tx_id  = $message->receipt;
    $amount = $message->totalAccountAmount;
    $sku    = $message->lineItems[0]->itemNo;

    // Insert into the "Filing Cabinet"
    $sql = "INSERT INTO clickbank_nexus_revenue (transaction_id, product_sku, sale_amount) 
            VALUES ('$tx_id', '$sku', '$amount')";

    $conn->query($sql);
    $conn->close();
}
?>
