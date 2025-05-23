<?php

function connect_db() {
    $dbPath = __DIR__ . '/grocery_store_vesna.db';
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function get_products($pdo) {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}