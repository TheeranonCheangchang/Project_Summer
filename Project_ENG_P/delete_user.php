<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include 'db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id='$id'");
header("Location: manage_users.php");
?>
