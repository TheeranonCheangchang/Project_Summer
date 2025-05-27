<?php
session_start();

include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager' && $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit();
}


if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('Invalid category ID!'); window.location='manage_category.php';</script>";
    exit();
}
$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $category = $result->fetch_assoc();
} else {
    echo "<script>alert('Category not found!'); window.location='manage_category.php';</script>";
    exit();
}


if (isset($_POST['update_category'])) {
    $name = $_POST['name'];
    
    $stmt = $conn->prepare("UPDATE categories SET name=? WHERE id=?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    
    echo "<script>alert('Category updated successfully!'); window.location='manage_category.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="sidebar_menu\sidebar.css">
    <style>
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }
        h2 {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
            margin-top: 15px;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <?php include 'sidebar_menu\sidebar.php'; ?>
    <div class="container">
        <h2>Edit Category</h2>
        <form method="POST" action="edit_category.php?id=<?php echo $category['id']; ?>">
            <label>Category Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
            <button type="submit" name="update_category">Update Category</button>
        </form>
    </div>
</body>
</html>
