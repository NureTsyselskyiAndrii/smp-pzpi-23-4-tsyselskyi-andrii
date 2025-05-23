<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$existingCart = $_SESSION['cart'];
$newItems = $_POST['cart'] ?? [];
$hasValidItems = false;

foreach ($newItems as $id => $data) {
    $name = trim($data['name']);
    $quantity = (int)$data['quantity'];
    $price = (float)$data['price'];

    if (!is_numeric($quantity) || $quantity < 0 || $quantity > 99) {
        $_SESSION['input_data'] = $_POST['cart'];
        $_SESSION['input_error'] = 'Перевірте будь ласка введені дані.';
        header('Location: /products');
        exit;
    }

    if ($quantity > 0) {
        $hasValidItems = true;

        if (isset($existingCart[$id])) {
            $existingCart[$id]['quantity'] += $quantity;
        } else {
            $existingCart[$id] = [
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price
            ];
        }
    }
}

if ($hasValidItems) {
    $_SESSION['cart'] = $existingCart;
    unset($_SESSION['input_data'], $_SESSION['input_error']);
    header('Location: /cart');
    exit;
} else {
    $_SESSION['input_error'] = 'Будь ласка, додайте хоча б один товар.';
    $_SESSION['input_data'] = $_POST['cart'];
    header('Location: /products');
    exit;
}