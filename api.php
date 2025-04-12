<?php
session_start();
header('Content-Type: application/json');

require_once 'db.php';

// Initialize cart session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getProducts':
        getProducts($pdo);
        break;

    case 'addToCart':
        addToCart();
        break;

    case 'removeFromCart':
        removeFromCart();
        break;

    case 'updateQuantity':
        updateQuantity();
        break;

    case 'getCart':
        getCart();
        break;

    case 'checkout':
        checkout();
        break;

    default:
        echo json_encode(['error' => 'Invalid action']);
}

// ==== Functions ====

function getProducts($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();
        echo json_encode($products);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

function addToCart() {
    $input = json_decode(file_get_contents('php://input'), true);
    $productId = $input['id'];
    $name = $input['name'];
    $price = $input['price'];

    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = [
            'id' => $productId,
            'name' => $name,
            'price' => $price,
            'quantity' => 1
        ];
    } else {
        $_SESSION['cart'][$productId]['quantity']++;
    }

    echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
}

function removeFromCart() {
    $input = json_decode(file_get_contents('php://input'), true);
    $productId = $input['id'];

    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }

    echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
}

function updateQuantity() {
    $input = json_decode(file_get_contents('php://input'), true);
    $productId = $input['id'];
    $quantity = (int)$input['quantity'];

    if (isset($_SESSION['cart'][$productId]) && $quantity > 0) {
        $_SESSION['cart'][$productId]['quantity'] = $quantity;
    }

    echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
}

function getCart() {
    echo json_encode(array_values($_SESSION['cart']));
}

function checkout() {
    $_SESSION['cart'] = []; // Clear the cart after checkout
    echo json_encode(['success' => true, 'message' => 'Order placed successfully!']);
}
