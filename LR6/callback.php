<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));

if (empty($name) || empty($phone)) {
    $_SESSION['alert'] = ['type' => 'danger', 'text' => 'Заполните имя и телефон'];
    header('Location: index.php');
    exit;
}

$to = 'kito8e@gmail.com';
$subject = 'Заказ звонка с сайта Fib Pasta Bar';
$body = "Имя: $name
Телефон: $phone
Комментарий: $message
";
$headers = "From: noreply@fibpasta.ru
";
$headers .= "Reply-To: $to
";
$headers .= "Content-Type: text/plain; charset=UTF-8
";

$result = mail($to, $subject, $body, $headers);

if ($result) {
    $_SESSION['alert'] = ['type' => 'success', 'text' => 'Заявка отправлена! Мы перезвоним вам.'];
} else {
    $_SESSION['alert'] = ['type' => 'danger', 'text' => 'Ошибка отправки. Попробуйте позже.'];
}

header('Location: index.php');
exit;
