<?php
session_start();

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$alert = $_SESSION['alert'] ?? null;
unset($_SESSION['alert']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $body_text = htmlspecialchars(trim($_POST['body'] ?? ''));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($subject) || empty($body_text)) {
        $_SESSION['alert'] = ['type' => 'danger', 'text' => 'Заполните все поля корректно'];
        header('Location: phpmailer_simple.php');
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
        $mail->Subject = $subject;
        $mail->Body = nl2br($body_text);
        $mail->AltBody = $body_text;

        $mail->send();
        $_SESSION['alert'] = ['type' => 'success', 'text' => 'Сообщение отправлено через PHPMailer!'];
    } catch (Exception $e) {
        $_SESSION['alert'] = ['type' => 'danger', 'text' => 'Ошибка: ' . $mail->ErrorInfo];
    }

    header('Location: phpmailer_simple.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPMailer - Простое сообщение</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="section-title mb-4">Отправка <span class="highlight">сообщения</span></h2>
                        <p class="text-muted mb-4">PHPMailer - простое сообщение без вложений</p>

                        <?php if ($alert): ?>
                        <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
                            <?php echo $alert['text']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Ваш email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Тема</label>
                                <input type="text" name="subject" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Сообщение</label>
                                <textarea name="body" class="form-control" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Отправить через PHPMailer</button>
                        </form>

                        <div class="mt-4 text-center">
                            <a href="index.php" class="text-decoration-none">← На главную</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
