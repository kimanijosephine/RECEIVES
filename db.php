<?php
$db_file = "transfers.db";

try {
    $conn = new PDO("sqlite:" . $db_file);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables if they don't exist
    $conn->exec("
        CREATE TABLE IF NOT EXISTS transfers (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            transaction_type TEXT,
            date TEXT,
            from_store TEXT,
            to_store TEXT
        );

        CREATE TABLE IF NOT EXISTS transfer_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            transfer_id INTEGER,
            item_code TEXT,
            item_name TEXT,
            quantity INTEGER,
            price REAL,
            approved INTEGER,
            FOREIGN KEY (transfer_id) REFERENCES transfers(id)
        );
    ");
} 
catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>
