<?php
session_start();
require_once 'functions.php';

$filters = [];
$filters['category'] = 'pizza';
if (!empty($_GET['search'])) $filters['search'] = trim($_GET['search']);
if (!empty($_GET['sort'])) $filters['sort'] = $_GET['sort'];
if (!empty($_GET['min_price'])) $filters['min_price'] = (float)$_GET['min_price'];
if (!empty($_GET['max_price'])) $filters['max_price'] = (float)$_GET['max_price'];

$allProducts = getProducts($pdo, $filters);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pagination = paginate($allProducts, $page, 8);
$products = $pagination['items'];
$cartCount = getCartCount();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пицца — Fib Pasta Bar</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php $alert = $_SESSION['alert'] ?? null; unset($_SESSION['alert']); if ($alert): ?>
<div class="container mt-3"><div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show"><?php echo $alert['text']; ?><button class="btn-close" data-bs-dismiss="alert"></button></div></div>
<?php endif; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="section-title-pasta mb-0">Пицца</h1>
        <a href="cart.php" class="cart-btn"><span class="cart-text">Корзина</span><span class="cart-sep"></span><span class="cart-count" id="cartCount"><?php echo $cartCount; ?></span></a>
    </div>

    <form method="GET" class="row g-3 mb-4 align-items-end">
        <div class="col-12 col-md-3"><input type="text" name="search" class="form-control" placeholder="Поиск..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>"></div>
        <div class="col-12 col-md-2">
            <select name="sort" class="form-select">
                <option value="">Сортировка</option>
                <option value="price_asc" <?php echo ($_GET['sort'] ?? '') === 'price_asc' ? 'selected' : ''; ?>>Цена ↑</option>
                <option value="price_desc" <?php echo ($_GET['sort'] ?? '') === 'price_desc' ? 'selected' : ''; ?>>Цена ↓</option>
                <option value="name_asc" <?php echo ($_GET['sort'] ?? '') === 'name_asc' ? 'selected' : ''; ?>>Название А-Я</option>
                <option value="name_desc" <?php echo ($_GET['sort'] ?? '') === 'name_desc' ? 'selected' : ''; ?>>Название Я-А</option>
            </select>
        </div>
        <div class="col-12 col-md-2"><input type="number" name="min_price" class="form-control" placeholder="Цена от" value="<?php echo htmlspecialchars($_GET['min_price'] ?? ''); ?>"></div>
        <div class="col-12 col-md-2"><input type="number" name="max_price" class="form-control" placeholder="Цена до" value="<?php echo htmlspecialchars($_GET['max_price'] ?? ''); ?>"></div>
        <div class="col-12 col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-fill">Применить</button>
            <a href="index.php" class="btn btn-outline-secondary">Сбросить</a>
        </div>
    </form>

    <div class="row g-4">
        <?php if (empty($products)): ?>
        <div class="col-12 text-center py-5"><p class="text-muted fs-5">Ничего не найдено</p></div>
        <?php else: ?>
        <?php foreach ($products as $product): ?>
        <div class="col-12 col-sm-6 col-lg-3">
            <article class="product-card h-100 d-flex flex-column p-3 rounded-3 bg-white">
                <div class="image-box mb-3"><img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid"></div>
                <div class="product-info flex-grow-1">
                    <h3 class="title mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="description mb-0"><?php echo htmlspecialchars($product['description']); ?>. <?php echo htmlspecialchars($product['weight']); ?></p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center mt-3 pt-2">
                    <p class="price mb-0"><?php echo number_format($product['price'], 0, '', ' '); ?> ₽</p>
                    <button class="add-btn" onclick="addToCart(<?php echo $product['id']; ?>)">В корзину</button>
                </div>
            </article>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if ($pagination['pages'] > 1): ?>
    <nav class="mt-5">
        <ul class="pagination justify-content-center">
            <?php if ($pagination['page'] > 1): ?><li class="page-item"><a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $pagination['page'] - 1])); ?>">Назад</a></li><?php endif; ?>
            <?php for ($i = 1; $i <= $pagination['pages']; $i++): ?>
            <li class="page-item <?php echo $i === $pagination['page'] ? 'active' : ''; ?>"><a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
            <?php if ($pagination['page'] < $pagination['pages']): ?><li class="page-item"><a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $pagination['page'] + 1])); ?>">Вперёд</a></li><?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="cartToast" class="toast align-items-center border-0"><div class="d-flex"><div class="toast-body fw-bold"><span style="color:var(--color-primary);margin-right:8px">&#10003;</span>Товар добавлен!</div><button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
window.addToCart = function(id) {
    fetch('cart_ajax.php?action=add&id=' + id).then(r => r.json()).then(d => {
        if (d.success) { document.getElementById('cartCount').textContent = d.count; new bootstrap.Toast(document.getElementById('cartToast'), {delay:2000}).show(); }
    });
};
</script>
</body>
</html>