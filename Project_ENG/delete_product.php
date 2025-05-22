<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager') {
    header("Location: index.php");
    exit();
}

include 'db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM products WHERE id='$id'");
header("Location: manage_product.php");
?>
