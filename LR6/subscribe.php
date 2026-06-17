<?php
session_start();

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['alert'] = ['type' => 'danger', 'text' => 'Введите корректный email'];
    header('Location: index.php#subscribe');
    exit;
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = $SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = $SMTP_USER;
    $mail->Password = $SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $SMTP_PORT;
    $mail->CharSet = 'UTF-8';

    $mail->setFrom($SMTP_FROM, $SMTP_FROM_NAME);
    $mail->addAddress($ADMIN_EMAIL);
    $mail->addReplyTo($email);

    $mail->isHTML(true);
    $mail->Subject = 'Новая подписка на рассылку';
    $mail->Body = "<h2>Новый подписчик</h2><p>Email: <b>$email</b></p><p>Дата: " . date('d.m.Y H:i') . "</p>";
    $mail->AltBody = "Новый подписчик
Email: $email
Дата: " . date('d.m.Y H:i');

    $mail->send();

    $mail->clearAddresses();
    $mail->addAddress($email);
    $mail->Subject = 'Вы подписались на рассылку Fib Pasta Bar';
    $mail->Body = "<h2>Спасибо за подписку!</h2><p>Теперь вы будете получать эксклюзивные акции и новости.</p>";
    $mail->AltBody = "Спасибо за подписку! Теперь вы будете получать эксклюзивные акции и новости.";
    $mail->send();

    $_SESSION['alert'] = ['type' => 'success', 'text' => 'Вы успешно подписались на рассылку!'];
} catch (Exception $e) {
    $_SESSION['alert'] = ['type' => 'danger', 'text' => 'Ошибка: ' . $mail->ErrorInfo];
}

header('Location: index.php#subscribe');
exit;
