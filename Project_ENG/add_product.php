<?php
session_start();
include 'db.php';

// บันทึกข้อมูลสินค้าใหม่
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    $stmt = $conn->prepare("INSERT INTO products (name, description) VALUES (?, ?)");
    $stmt->bind_param("s", $name, $description);
    $stmt->execute();
    
    echo "<script>alert('Product added successfully!'); window.location='manage_product.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input, textarea, select {
            width: 96%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>
        <form method="POST" action="add_product.php">
            <label>Product Name:</label>
            <input type="text" name="name" required>
            
            <label>Description:</label>
            <textarea name="description" required></textarea>
            
            <button type="submit" name="add_product">SAVE</button>
        </form>
    </div>
</body>
</html>
