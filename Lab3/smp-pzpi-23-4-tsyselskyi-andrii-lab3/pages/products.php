<?php 
session_start();
require_once __DIR__ . '/../database/db_functions.php';
$pdo = connect_db();
$products = get_products($pdo);

$inputData = $_SESSION['input_data'] ?? [];
$inputError = $_SESSION['input_error'] ?? '';
unset($_SESSION['input_data'], $_SESSION['input_error']);
?>

<div class="product-page">
    <h1>Доступні товари</h1>

    <?php if ($inputError): ?>
    <div class="error-message"><?php echo htmlspecialchars($inputError); ?></div>
    <?php endif; ?>

    <form method="POST" action="/utils/save_cart.php" class="product-selection-form">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Назва</th>
                    <th>Кількість</th>
                    <th>Ціна</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): 
                $id = $product['id'];
                $oldQuantity = $inputData[$id]['quantity'] ?? 0;
            ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td>
                        <input type="hidden" name="cart[<?php echo $id; ?>][name]"
                            value="<?php echo htmlspecialchars($product['name']); ?>">
                        <input type="number" name="cart[<?php echo $id; ?>][quantity]"
                            value="<?php echo htmlspecialchars($oldQuantity); ?>" class="quantity-input">
                        <input type="hidden" name="cart[<?php echo $id; ?>][price]"
                            value="<?php echo $product['price']; ?>">
                    </td>
                    <td><?php echo $product['price']; ?> грн</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="form-actions">
            <button type="submit" class="submit-button">Додати до кошика</button>
        </div>
    </form>
</div>