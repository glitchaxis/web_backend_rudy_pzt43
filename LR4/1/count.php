<?php
    session_start();

    if (!isset($_SESSION['page_views'])) {
        $_SESSION['page_views'] = 0;
    }
    $_SESSION['page_views']++;

    if (!isset($_COOKIE['last_visit'])) {
        setcookie('last_visit', date('Y-m-d H:i:s'), time() + 86400 * 30, '/', '', true, true);
    }
    $lastVisit = $_COOKIE['last_visit'] ?? 'первый раз';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Счётчик посещений</title>
</head>

<body>
    <h3>Вы открыли эту страницу <?= $_SESSION['page_views'] ?> раз(а)</h3>
    <p>Предыдущий визит: <?= htmlspecialchars($lastVisit) ?></p>
    <a href="<?= $_SERVER['SCRIPT_NAME'] ?>">Обновить</a>
</body>

</html>