<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit();
}


$categories = $conn->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    
    body {
      font-family: "Kanit", sans-serif;
      display: flex;
      margin: 0;
      padding: 0;
    }
    
    .kanit-regular {
      font-family: "Kanit", sans-serif;
      font-weight: 300;
      font-style: normal;
    }
    
    .sidebar {
      width: 200px;
      height: 900px;
      background-color: rgb(72, 130, 255);
      color: white;
      padding: 20px;
    }

    .sidebar img {
      max-width: 80%;
      height: auto;
      margin: auto auto;
      display: block;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 10px;
      margin-bottom: 5px;
    }

    .sidebar a:hover {
      background-color: rgb(19, 97, 255);
      border-radius: 5px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            color: black;
        }
        th {
            background: rgba(0, 0, 0, 0.3);
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }
        .edit-btn {
            background: #007bff;
            color: white;
        }
        .edit-btn:hover {
            background: #0056b3;
        }
        .delete-btn {
            background: #dc3545;
            color: white;
        }
        .delete-btn:hover {
            background: #c82333;
        }
        .add-category {
            margin-top: 20px;
            display: inline-block;
            padding: 12px 20px;
            background: #28a745;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }
        .add-category:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="sidebar">
    <div class="mb-4 text-center">
      <img src="https://images.workpointtoday.com/workpointtv/2020/09/16045608/cropped-favicon.png" class="rounded-circle mb-2" alt="User">
    </div>
        <a href="manage_users.php" class="option-card">จัดการผู้ใช้งาน</a>
    <a href="manage_category.php" class="option-card">จัดการแผนก</a>
    <a href="dashboard.php" class="option-card">การแจ้งซ่อม</a>
    <a href="logout.php" class="option-card logout">Logout</a>
  </div>

<div class="container">
        <h2>Manage Categories</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
            <?php while ($category = $categories->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($category['id']); ?></td>
                <td><?php echo htmlspecialchars($category['name']); ?></td>
                <td>
                    <a href="edit_category.php?id=<?php echo $category['id']; ?>" class="btn edit-btn">Edit</a>
                    <a href="delete_category.php?id=<?php echo $category['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="add_category.php" class="add-category">Add New Category</a>
    </div>
</body>
</html>