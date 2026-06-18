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
$freeDelivery = 1500;
$remaining = max(0, $freeDelivery - $total);
$progress = min(100, ($total / $freeDelivery) * 100);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина — Fib Pasta Bar</title>
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
                <h2 class="section-title mb-0">Корзина</h2>
                <a href="index.php" class="btn btn-outline-secondary">← В меню</a>
            </div>

            <?php if (empty($cartItems)): ?>
            <div class="card border-0 shadow-sm p-5 text-center">
                <p class="text-muted fs-5 mb-4">Корзина пуста</p>
                <a href="index.php" class="btn btn-primary">В меню</a>
            </div>
            <?php else: ?>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    <?php foreach ($cartItems as $item): ?>
                    <div class="d-flex align-items-center gap-3 p-3 border-bottom cart-item" data-id="<?php echo $item['id']; ?>">
                        <img src="<?php echo $item['image']; ?>" width="80" height="80" class="rounded-3" alt="">
                        <div class="flex-grow-1">
                            <div class="fw-bold" style="font-size:15px"><?php echo htmlspecialchars($item['name']); ?></div>
                            <div class="text-muted" style="font-size:13px"><?php echo number_format($item['price'], 0, '', ' '); ?> ₽ / шт.</div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-outline-secondary qty-btn" data-action="minus" style="width:32px;height:32px;padding:0">−</button>
                            <span class="fw-bold" style="min-width:30px;text-align:center"><?php echo $item['quantity']; ?></span>
                            <button class="btn btn-sm btn-outline-secondary qty-btn" data-action="plus" style="width:32px;height:32px;padding:0">+</button>
                        </div>
                        <div class="fw-bold" style="min-width:100px;text-align:right;font-size:16px"><span class="item-subtotal"><?php echo number_format($item['subtotal'], 0, '', ' '); ?></span> ₽</div>
                        <button class="btn btn-sm btn-link text-danger remove-btn" style="font-size:18px;padding:0 8px">×</button>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4 p-4">
                <p class="mb-2 fw-bold" style="font-size:14px">До бесплатной доставки:</p>
                <div class="progress" style="height:8px"><div class="progress-bar" style="width:<?php echo $progress; ?>%"></div></div>
                <p class="mt-2 text-muted" style="font-size:13px"><?php echo $remaining > 0 ? 'Осталось ' . number_format($remaining, 0, '', ' ') . ' ₽' : 'Бесплатная доставка!'; ?></p>
            </div>

            <div class="card border-0 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fw-bold fs-5">Итого:</span>
                    <span class="fw-bold" style="font-size:28px;color:var(--color-primary)"><span id="cartTotal"><?php echo number_format($total, 0, '', ' '); ?></span> ₽</span>
                </div>
                <a href="checkout.php" class="btn btn-primary w-100" style="font-size:18px;padding:16px">Оформить заказ</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.qty-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const item = this.closest('.cart-item');
        const id = item.dataset.id;
        const action = this.dataset.action;
        const qtySpan = item.querySelector('span.fw-bold');
        let qty = parseInt(qtySpan.textContent);
        if (action === 'plus') qty++; else if (action === 'minus') qty--;
        if (qty <= 0) { item.remove(); }
        else { qtySpan.textContent = qty; }
        fetch('cart_ajax.php?action=update&id=' + id + '&qty=' + qty).then(r => r.json()).then(d => {
            if (d.success) {
                document.getElementById('cartTotal').textContent = d.total.toLocaleString('ru-RU');
                if (qty > 0) {
                    const price = parseInt(item.querySelector('.text-muted').textContent.replace(/\D/g, ''));
                    item.querySelector('.item-subtotal').textContent = (price * qty).toLocaleString('ru-RU');
                }
            }
        });
    });
});
document.querySelectorAll('.remove-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const item = this.closest('.cart-item');
        fetch('cart_ajax.php?action=remove&id=' + item.dataset.id).then(r => r.json()).then(d => {
            if (d.success) { item.remove(); document.getElementById('cartTotal').textContent = d.total.toLocaleString('ru-RU'); }
        });
    });
});
</script>
</body>
</html>