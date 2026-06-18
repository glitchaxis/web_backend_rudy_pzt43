<?php
require_once 'config.php';

function getProducts($pdo, $filters = []) {
    $where = ["p.is_active = 1", "c.slug = 'pizza'"];
    $params = [];

    if (!empty($filters['search'])) {
        $where[] = "(p.name LIKE ? OR p.description LIKE ?)";
        $params[] = '%' . $filters['search'] . '%';
        $params[] = '%' . $filters['search'] . '%';
    }
    if (!empty($filters['min_price'])) {
        $where[] = "p.price >= ?";
        $params[] = $filters['min_price'];
    }
    if (!empty($filters['max_price'])) {
        $where[] = "p.price <= ?";
        $params[] = $filters['max_price'];
    }

    $orderBy = "p.id";
    if (!empty($filters['sort'])) {
        switch ($filters['sort']) {
            case 'price_asc': $orderBy = "p.price ASC"; break;
            case 'price_desc': $orderBy = "p.price DESC"; break;
            case 'name_asc': $orderBy = "p.name ASC"; break;
            case 'name_desc': $orderBy = "p.name DESC"; break;
        }
    }

    $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
            FROM products p JOIN categories c ON p.category_id = c.id 
            WHERE " . implode(' AND ', $where) . " ORDER BY $orderBy";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getProductById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ? AND p.is_active = 1");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function paginate($items, $page = 1, $perPage = 8) {
    $total = count($items);
    $pages = max(1, ceil($total / $perPage));
    $page = max(1, min($page, $pages));
    $offset = ($page - 1) * $perPage;
    return [
        'items' => array_slice($items, $offset, $perPage),
        'total' => $total,
        'pages' => $pages,
        'page' => $page,
        'perPage' => $perPage
    ];
}

function getCart() { return $_SESSION['cart'] ?? []; }
function addToCart($id, $qty = 1) {
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;
}
function removeFromCart($id) { unset($_SESSION['cart'][$id]); }
function updateCartQuantity($id, $qty) {
    if ($qty <= 0) removeFromCart($id);
    else $_SESSION['cart'][$id] = $qty;
}
function clearCart() { $_SESSION['cart'] = []; }
function getCartCount() { return array_sum(getCart()); }

function getCartTotal($pdo) {
    $total = 0;
    foreach (getCart() as $id => $qty) {
        $p = getProductById($pdo, $id);
        if ($p) $total += $p['price'] * $qty;
    }
    return $total;
}

function createOrder($pdo, $data, $items) {
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_phone, customer_email, delivery_address, comment, total_amount) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data['name'], $data['phone'], $data['email'] ?? '', $data['address'], $data['comment'] ?? '', $data['total']]);
        $orderId = $pdo->lastInsertId();

        $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_price, quantity) VALUES (?, ?, ?, ?, ?)");
        foreach ($items as $item) {
            $stmtItem->execute([$orderId, $item['id'], $item['name'], $item['price'], $item['quantity']]);
        }
        $pdo->commit();
        return $orderId;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

function getOrderById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute([$id]);
    $order = $stmt->fetch();
    if ($order) {
        $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->execute([$id]);
        $order['items'] = $stmt->fetchAll();
    }
    return $order;
}
