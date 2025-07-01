<?php
class User {
    public function find($username) {
        $db = db_connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($username, $password) {
        $db = db_connect();
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
        $stmt->execute();
    }
}
