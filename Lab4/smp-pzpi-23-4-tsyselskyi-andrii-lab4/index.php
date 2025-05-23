<?php
    session_start();
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = trim($uri, '/');
    $page = $uri === '' ? 'home' : basename($uri);
    $pagesAllowedWithoutAuth = ['login', 'home', 'about'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Продуктовий магазин Весна</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php  require_once("components/header.php"); ?>

    <main>
        <?php
            if ($page && !file_exists("pages/$page.php")) {
                require_once("pages/not_found_page.php");
            }
            else{
                if (!isset($_SESSION['username']) && !in_array($page, $pagesAllowedWithoutAuth)) {
                    require_once("pages/page404.php");
                }
                else{
                    require_once("pages/$page.php");
                }
            }
        ?>
    </main>

    <?php  require_once("components/footer.php"); ?>
</body>

</html>