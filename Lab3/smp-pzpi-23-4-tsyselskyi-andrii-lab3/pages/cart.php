<?php
    session_start();
    $total = 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['remove_id'])) {
            unset($_SESSION['cart'][$_POST['remove_id']]);
        } elseif (isset($_POST['action']) && $_POST['action'] === 'clear') {
            $_SESSION['cart'] = [];
        } elseif (isset($_POST['action']) && $_POST['action'] === 'pay') {
            $_SESSION['cart'] = [];
            $_SESSION['success_message'] = 'Дякуємо за покупку!';
            header('Location: /cart');
            exit;
        }
    }

    $cart = $_SESSION['cart'] ?? [];
    $successMessage = $_SESSION['success_message'] ?? '';
    unset($_SESSION['success_message']);
?>

<div class="cart-page">
    <?php if ($successMessage): ?>
    <div class="cart-success"><?php echo htmlspecialchars($successMessage); ?></div>
    <?php endif; ?>

    <?php if (empty($cart)): ?>
    <div class="cart-empty">
        <p>Ваш кошик порожній.</p>
        <a href="/products" class="button-link">Перейти до покупок</a>
    </div>
    <?php else: ?>
    <h2 class="cart-title">Ваш кошик</h2>
    <table class="cart-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Назва</th>
                <th>Ціна</th>
                <th>Кількість</th>
                <th>Сума</th>
                <th>Дія</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart as $id => $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo $item['price']; ?> грн</td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo $subtotal; ?> грн</td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="remove_id" value="<?php echo $id; ?>">
                        <button type="submit" class="btn-delete">Видалити</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr class="cart-total-row">
                <td colspan="4" class="text-right">Разом:</td>
                <td colspan="2"><?php echo $total; ?> грн</td>
            </tr>
        </tbody>
    </table>

    <form method="POST" class="cart-actions">
        <button type="submit" name="action" value="clear" class="btn-clear">Очистити</button>
        <button type="submit" name="action" value="pay" class="btn-pay">Сплатити</button>
    </form>
    <?php endif; ?>
</div>