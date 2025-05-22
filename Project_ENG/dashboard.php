<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: rgb(255, 255, 255);
            color: rgb(0, 0, 0);;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }
        h2 {
            margin-bottom: 20px;
        }
        .dashboard-options {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .option-card {
            background: rgb(150, 150, 150);
            color: rgb(0, 0, 0);;
            padding: 15px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
            width: 220px;
            text-align: center;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
        }
        .option-card:hover {
            background: rgba(255, 255, 255, 0.5);
            transform: translateY(-5px);
        }
        .logout {
            background: rgba(255, 0, 0, 0.7);
        }
        .logout:hover {
            background: rgba(255, 0, 0, 0.9);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manager Dashboard</h2>
        <div class="dashboard-options">
            <a href="manage_product.php" class="option-card">Manage Products</a>
            <a href="manage_users.php" class="option-card">Manage Users</a>
            <a href="manage_category.php" class="option-card">Manage Categories</a>
            <a href="logout.php" class="option-card logout">Logout</a>
        </div>
    </div>
</body>
</html>
