<?php
include "db.php";

// MAIN FORM DATA
$transaction_type = $_POST["transaction_type"];
$date = $_POST["date"];
$from_store = $_POST["from_store"];
$to_store = $_POST["to_store"];

// Insert transfer
$stmt = $conn->prepare("
    INSERT INTO transfers (transaction_type, date, from_store, to_store)
    VALUES (?, ?, ?, ?)
");
$stmt->execute([$transaction_type, $date, $from_store, $to_store]);

$transfer_id = $conn->lastInsertId();

// Insert items
for ($i=0; $i<count($_POST["item_code"]); $i++) {

    $item_code = $_POST["item_code"][$i];
    $item_name = $_POST["item_name"][$i];
    $qty       = $_POST["qty"][$i];
    $price     = $_POST["price"][$i];
    $approved  = isset($_POST["approved"][$i]) ? 1 : 0;

    $stmt2 = $conn->prepare("
        INSERT INTO transfer_items 
        (transfer_id, item_code, item_name, quantity, price, approved)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt2->execute([$transfer_id, $item_code, $item_name, $qty, $price, $approved]);
}

echo "SUCCESS: Transfer saved successfully!";
?>
