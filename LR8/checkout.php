<?php
session_start();
require_once 'functions.php';

$cart = getCart();
$cartItems = [];
$total = 0;
foreach ($cart as $id => $qty) {
    $product = getProductById($pdo, $id);
    if ($product) {
        $product['quantity'] = $qty;
        $product['subtotal'] = $product['price'] * $qty;
        $cartItems[] = $product;
        $total += $product['subtotal'];
    }
}

if (empty($cartItems)) {
    $_SESSION['alert'] = ['type' => 'warning', 'text' => 'Корзина пуста'];
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $address = htmlspecialchars(trim($_POST['address'] ?? ''));
    $comment = htmlspecialchars(trim($_POST['comment'] ?? ''));

    if (empty($name) || empty($phone) || empty($address)) {
        $_SESSION['alert'] = ['type' => 'danger', 'text' => 'Заполните все обязательные поля'];
        header('Location: checkout.php');
        exit;
    }

    $orderId = createOrder($pdo, ['name' => $name, 'phone' => $phone, 'email' => $email, 'address' => $address, 'comment' => $comment, 'total' => $total], $cartItems);

    if ($orderId) {
        clearCart();
        $_SESSION['alert'] = ['type' => 'success', 'text' => "Заказ №$orderId оформлен!"];
        header('Location: order_success.php?id=' . $orderId);
        exit;
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'text' => 'Ошибка оформления'];
        header('Location: checkout.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оформление заказа — Fib Pasta Bar</title>
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
        <div class="col-12 col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0">Оформление заказа</h2>
                <a href="cart.php" class="btn btn-outline-secondary">← В корзину</a>
            </div>
            <div class="row g-4">
                <div class="col-12 col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form method="POST">
                                <div class="mb-3"><label class="form-label">Имя *</label><input type="text" name="name" class="form-control" required></div>
                                <div class="mb-3"><label class="form-label">Телефон *</label><input type="tel" name="phone" class="form-control" required></div>
                                <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control"></div>
                                <div class="mb-3"><label class="form-label">Адрес доставки *</label><textarea name="address" class="form-control" rows="3" required></textarea></div>
                                <div class="mb-4"><label class="form-label">Комментарий</label><textarea name="comment" class="form-control" rows="3"></textarea></div>
                                <button type="submit" class="btn btn-primary w-100" style="font-size:16px;padding:14px">Подтвердить заказ</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Ваш заказ</h5>
                            <?php foreach ($cartItems as $item): ?>
                            <div class="d-flex justify-content-between align-items-center mb-2 py-2 border-bottom">
                                <div><div style="font-size:14px"><?php echo htmlspecialchars($item['name']); ?></div><div class="text-muted" style="font-size:12px"><?php echo $item['quantity']; ?> × <?php echo number_format($item['price'], 0, '', ' '); ?> ₽</div></div>
                                <div class="fw-bold" style="font-size:14px"><?php echo number_format($item['subtotal'], 0, '', ' '); ?> ₽</div>
                            </div>
                            <?php endforeach; ?>
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-2">
                                <span class="fw-bold fs-5">Итого:</span>
                                <span class="fw-bold" style="font-size:24px;color:var(--color-primary)"><?php echo number_format($total, 0, '', ' '); ?> ₽</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>