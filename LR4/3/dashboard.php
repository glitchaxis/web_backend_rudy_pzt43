<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$timeout = 900;
if (time() - ($_SESSION['logged_at'] ?? 0) > $timeout) {
    session_destroy();
    header('Location: login.php?expired=1');
    exit;
}
$_SESSION['logged_at'] = time();
?>
<!DOCTYPE html>
<html>
<head><title>Панель администратора</title></head>
<body>
<h1>Добро пожаловать, <?= htmlspecialchars($_SESSION['user']) ?></h1>
<p>Роль: <?= htmlspecialchars($_SESSION['role']) ?></p>
<a href="logout.php">Выйти</a>
</body>
</html>