<?php
$dbPath = __DIR__ . '/grocery_store_vesna.db';
$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("
    CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL UNIQUE,
        price REAL NOT NULL
    )
");

$pdo->exec("
    INSERT INTO products (name, price) VALUES
    ('Молоко пастеризоване', 12.00),
    ('Хліб чорний', 9.00),
    ('Сир білий', 21.00),
    ('Сметана 20%', 25.00),
    ('Кефір 1%', 19.00),
    ('Вода газована', 18.00),
    ('Печиво \"Весна\"', 14.00)
");

echo "База даних та таблиці були успішно створені!";