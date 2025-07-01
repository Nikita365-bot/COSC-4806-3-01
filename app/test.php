<?php
require_once 'app/core/config.php'; // Make sure this is correct

function db_connect() {
    try {
        $db = new PDO("mysql:host=5q31t.h.filess.io;dbname=COSC4806_hospitalbe", "COSC4806_hospitalbe", "3e28149537989a420833f609e3a9ba9a187965e1");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        die("DB Error: " . $e->getMessage());
    }
}

try {
    $db = db_connect();
    echo "✅ Connected to the database successfully!";
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
