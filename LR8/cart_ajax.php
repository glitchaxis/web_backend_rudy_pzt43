<?php
session_start();
require_once 'functions.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

switch ($action) {
    case 'add':
        if ($id > 0) { addToCart($id); echo json_encode(['success' => true, 'count' => getCartCount()]); }
        else echo json_encode(['success' => false]);
        break;
    case 'remove':
        if ($id > 0) { removeFromCart($id); echo json_encode(['success' => true, 'count' => getCartCount(), 'total' => getCartTotal($pdo)]); }
        else echo json_encode(['success' => false]);
        break;
    case 'update':
        $qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 0;
        if ($id > 0 && $qty >= 0) { updateCartQuantity($id, $qty); echo json_encode(['success' => true, 'count' => getCartCount(), 'total' => getCartTotal($pdo)]); }
        else echo json_encode(['success' => false]);
        break;
    default:
        echo json_encode(['success' => false]);
}
