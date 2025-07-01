<?php
function db_connect() {
    try {
        return new PDO(
            'mysql:host=5q31t.h.filess.io;port=3305;dbname=COSC4806_hospitalbe',
            'COSC4806_hospitalbe',
            '3e28149537989a420833f609e3a9ba9a187965e1',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        die("DB Connection failed: " . $e->getMessage());
    }
}
