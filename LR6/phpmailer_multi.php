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
    $emails_raw = trim($_POST['emails'] ?? '');
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $body_text = htmlspecialchars(trim($_POST['body'] ?? ''));

    $emails = array_filter(array_map('trim', explode(',', $emails_raw)));
    $valid_emails = [];
    foreach ($emails as $e) {
        if (filter_var($e, FILTER_VALIDATE_EMAIL)) {
            $valid_emails[] = $e;
        }
    }

    if (empty($valid_emails) || empty($subject) || empty($body_text)) {
        $_SESSION['alert'] = ['type' => 'danger', 'text' => 'Введите хотя бы один корректный email, тему и сообщение'];
        header('Location: phpmailer_multi.php');
        exit;
    }

    $mail = new PHPMailer(true);
    $sent = 0;
    $errors = [];

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
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = nl2br($body_text);
        $mail->AltBody = $body_text;

        foreach ($valid_emails as $email) {
            $mail->clearAddresses();
            $mail->addAddress($email);
            try {
                $mail->send();
                $sent++;
            } catch (Exception $e) {
                $errors[] = $email . ': ' . $mail->ErrorInfo;
            }
        }

        if ($sent > 0) {
            $_SESSION['alert'] = ['type' => 'success', 'text' => "Отправлено $sent из " . count($valid_emails) . " адресатов"];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'text' => 'Ошибка отправки всем адресатам'];
        }
    } catch (Exception $e) {
        $_SESSION['alert'] = ['type' => 'danger', 'text' => 'Ошибка: ' . $mail->ErrorInfo];
    }

    header('Location: phpmailer_multi.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPMailer - Несколько адресатов</title>
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
                        <h2 class="section-title mb-4">Несколько <span class="highlight">адресатов</span></h2>
                        <p class="text-muted mb-4">PHPMailer - отправка письма сразу нескольким получателям. Введите email через запятую.</p>

                        <?php if ($alert): ?>
                        <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
                            <?php echo $alert['text']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Email адресаты (через запятую)</label>
                                <textarea name="emails" class="form-control" rows="3" placeholder="email1@gmail.com, email2@yandex.ru, email3@mail.ru" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Тема</label>
                                <input type="text" name="subject" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Сообщение</label>
                                <textarea name="body" class="form-control" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Отправить нескольким адресатам</button>
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
