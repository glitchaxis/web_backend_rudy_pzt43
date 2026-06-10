<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $pass = $_POST['password'] ?? '';

    $validLogin = 'admin';
    $validHash = password_hash('12345', PASSWORD_DEFAULT);

    if ($login === $validLogin && password_verify($pass, $validHash)) {
        session_regenerate_id(true);
        $_SESSION['user'] = $login;
        $_SESSION['role'] = 'admin';
        $_SESSION['logged_at'] = time();
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Неверный логин или пароль';
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Вход в админку</title></head>
<body>
<h2>Авторизация</h2>
<?php if ($error): ?>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<form method="post">
<input type="text" name="login" placeholder="Логин" required><br>
<input type="password" name="password" placeholder="Пароль" required><br>
<button type="submit">Войти</button>
</form>
</body>
</html>