<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['name'])) $errors[] = "Имя не введено";
    if (empty($_POST['email'])) $errors[] = "Почта не введена";
    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный email";
    }
    if (empty($_POST['password'])) $errors[] = "Пароль не введен";
    if (strlen($_POST['password']) < 6) $errors[] = "Пароль не может быть меньше 6 символов";
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $errors[] = "Пароли не совпадают";
    }
    if (empty($errors)) {
        echo "Регистрация успешна!";
        echo "Имя: " . htmlspecialchars($_POST['name']) . "<br>";
        echo "Email: " . htmlspecialchars($_POST['email']) . "<br>";
        exit;
    }
}
?>
<?php if (!empty($errors)): ?>
<ul>
<?php foreach ($errors as $error): ?>
    <li><?= htmlspecialchars($error) ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<form action="register.php" method="POST">
    <label>Имя:</label><br>
    <input type="text" name="name"><br><br>
    <label>Email:</label><br>
    <input type="email" name="email"><br><br>
    <label>Пароль:</label><br>
    <input type="password" name="password"><br><br>
    <label>Подтвердите пароль:</label><br>
    <input type="password" name="confirm_password"><br><br>
    <input type="submit" value="Зарегистрироваться">
</form>
