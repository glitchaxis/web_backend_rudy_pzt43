<?php
session_start();
require_once 'functions.php';

$orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$order = getOrderById($pdo, $orderId);

if (!$order) {
    header('Location: index.php');
    exit;
}

$statusLabels = ['new' => 'Новый', 'processing' => 'В обработке', 'delivered' => 'Доставлен', 'cancelled' => 'Отменен'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Заказ оформлен — Fib Pasta Bar</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">

<?php $alert = $_SESSION['alert'] ?? null; unset($_SESSION['alert']); if ($alert): ?>
<div class="container mt-3"><div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show"><?php echo $alert['text']; ?><button class="btn-close" data-bs-dismiss="alert"></button></div></div>
<?php endif; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm text-center p-5">
                <div class="mb-4"><span style="font-size:64px;color:var(--color-primary)">&#10003;</span></div>
                <h2 class="section-title mb-3">Заказ <span class="highlight">оформлен!</span></h2>
                <p class="text-muted mb-4">Номер заказа: <strong>#<?php echo $order['id']; ?></strong></p>
                <div class="text-start bg-light rounded-3 p-4 mb-4">
                    <p><strong>Имя:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                    <p><strong>Телефон:</strong> <?php echo htmlspecialchars($order['customer_phone']); ?></p>
                    <p><strong>Адрес:</strong> <?php echo htmlspecialchars($order['delivery_address']); ?></p>
                    <p><strong>Сумма:</strong> <?php echo number_format($order['total_amount'], 0, '', ' '); ?> ₽</p>
                    <p><strong>Статус:</strong> <?php echo $statusLabels[$order['status']] ?? $order['status']; ?></p>
                </div>
                <a href="index.php" class="btn btn-primary w-100">Вернуться в меню</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>