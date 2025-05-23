<?php
session_start();
unset($_SESSION['username'], $_SESSION['authorized_at']);
header('Location: /');
exit;

?>