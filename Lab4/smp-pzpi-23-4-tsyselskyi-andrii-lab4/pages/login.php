<?php 
require './utils/credential.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
  $formUsername = $_POST['username'];
  $formPassword = $_POST['password'];

  if (isset($credentials['username'], $credentials['password'])) {
    if ($credentials['username'] == $formUsername && $credentials['password'] == $formPassword) {
      $_SESSION['username'] = $formUsername;
      $_SESSION['authorized_at'] = date("Y-m-d H:i:s");
      header('Location: /products');
      exit;
    } else {
      $_SESSION['input_error'] = 'Невірне ім’я користувача або пароль.';
    }
  } else {
    $_SESSION['input_error'] = 'Помилка зчитування облікових даних.';
  }
}

$inputError = $_SESSION['input_error'] ?? '';
unset($_SESSION['input_error']);
?>

<div class="login-box">
    <h2>🔐 Вхід</h2>

    <?php if ($inputError): ?>
    <div class="login-error"><?php echo htmlspecialchars($inputError); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Ім’я користувача" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Увійти</button>
    </form>
</div>