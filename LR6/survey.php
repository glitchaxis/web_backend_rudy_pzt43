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
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $rating = htmlspecialchars(trim($_POST['rating'] ?? ''));
    $favorite = htmlspecialchars(trim($_POST['favorite'] ?? ''));
    $comment = htmlspecialchars(trim($_POST['comment'] ?? ''));
    $method = $_POST['method'] ?? 'phpmailer';

    if (empty($name) || empty($email) || empty($phone) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['alert'] = ['type' => 'danger', 'text' => 'Заполните все обязательные поля корректно'];
        header('Location: survey.php');
        exit;
    }

    $subject = 'Анкета клиента Fib Pasta Bar';
    $body = "Имя: $name
Email: $email
Телефон: $phone
Оценка: $rating
Любимое блюдо: $favorite
Комментарий: $comment
Дата: " . date('d.m.Y H:i');
    $html_body = "<h2>Анкета клиента</h2>
        <p><b>Имя:</b> $name</p>
        <p><b>Email:</b> $email</p>
        <p><b>Телефон:</b> $phone</p>
        <p><b>Оценка:</b> $rating</p>
        <p><b>Любимое блюдо:</b> $favorite</p>
        <p><b>Комментарий:</b> $comment</p>
        <p><b>Дата:</b> " . date('d.m.Y H:i') . "</p>";

    if ($method === 'mail') {
        $headers = "From: noreply@fibpasta.ru
";
        $headers .= "Reply-To: $email
";
        $headers .= "Content-Type: text/plain; charset=UTF-8
";
        $result = mail($ADMIN_EMAIL, $subject, $body, $headers);

        if ($result) {
            $_SESSION['alert'] = ['type' => 'success', 'text' => 'Анкета отправлена через mail()!'];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'text' => 'Ошибка отправки через mail()'];
        }
    } else {
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
            $mail->Body = $html_body;
            $mail->AltBody = $body;

            $mail->send();
            $_SESSION['alert'] = ['type' => 'success', 'text' => 'Анкета отправлена через PHPMailer!'];
        } catch (Exception $e) {
            $_SESSION['alert'] = ['type' => 'danger', 'text' => 'Ошибка: ' . $mail->ErrorInfo];
        }
    }

    header('Location: survey.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Анкета клиента</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="section-title mb-4">Анкета <span class="highlight">клиента</span></h2>
                        <p class="text-muted mb-4">Помогите нам стать лучше — заполните анкету</p>

                        <?php if ($alert): ?>
                        <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
                            <?php echo $alert['text']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Ваше имя *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Телефон *</label>
                                <input type="tel" name="phone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Оценка сервиса</label>
                                <select name="rating" class="form-select">
                                    <option value="5">Отлично</option>
                                    <option value="4">Хорошо</option>
                                    <option value="3">Удовлетворительно</option>
                                    <option value="2">Плохо</option>
                                    <option value="1">Ужасно</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Любимое блюдо</label>
                                <input type="text" name="favorite" class="form-control" placeholder="Например: Карбонара">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Комментарий</label>
                                <textarea name="comment" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Способ отправки</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="method" value="phpmailer" id="methodPhp" checked>
                                    <label class="form-check-label" for="methodPhp">PHPMailer (SMTP)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="method" value="mail" id="methodMail">
                                    <label class="form-check-label" for="methodMail">mail()</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Отправить анкету</button>
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
