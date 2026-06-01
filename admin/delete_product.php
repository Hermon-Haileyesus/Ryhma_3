<?php
session_start();
require_once "../includes/db.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: ../log_in.php");
    exit;
}

$stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$role = $stmt->fetchColumn();

if ($role !== 'admin') {
    header("Location: ../index.php");
    exit;
}


if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$product_id = intval($_GET['id']);

$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$product_id]);


header("Location: index.php");
exit;
?>