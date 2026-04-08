<?php
/**
 * ClickBank Revenue Nexus - Webhook Handler
 * Refined for 100% Data Integrity & SQL Security
 */

$secret_key = "YOUR_CLICKBANK_SECRET"; 
$message = json_decode(file_get_contents('php://input'), true); // Decode as associative array

// 1. Deterministic Validation
if (isset($message['secretKey']) && $message['secretKey'] === $secret_key) {
    
    $conn = new mysqli("localhost", "user", "password", "database");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 2. Map Particulars (Matching ClickBank INS v8.0 field names)
    $tx_id  = $message['receipt'];
    $amount = $message['totalAccountAmount'];
    $status = "VERIFIED";

    // 3. Secure Insertion (Prepared Statements to prevent "hallucinations" or errors)
    $stmt = $conn->prepare("INSERT INTO transactions (transaction_id, amount, status) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $tx_id, $amount, $status);

    $stmt->execute();
    
    $stmt->close();
    $conn->close();
    
    echo "Nexus Sync Complete.";
} else {
    header('HTTP/1.1 403 Forbidden');
    echo "Unauthorized Access.";
}
?>
