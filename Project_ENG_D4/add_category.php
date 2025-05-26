<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit();
}
if (isset($_POST['add_category'])) {
    $name = $_POST['name'];
    
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    
    echo "<script>alert('Category added successfully!'); window.location='manage_category.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
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

    .main {
      flex: 1;
      background-color: #ecf0f1;
      padding: 20px;
    }

    table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 10px;
            overflow:initial;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            color: black;
        }
        th {
            background: rgba(0, 0, 0, 0.3);
        }
        button {
            width: 50%;
            padding: 2px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.8);
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
            width: 100%;
            padding: 10px;
            margin-top: 5px;
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
            transition: 0.3s;
            margin-top: 15px;
        }
        button:hover {
            background: #0056b3;
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
    <a href="dashboard.php" class="option-card">รายการแจ้งซ่อม</a>
    <a href="logout.php" class="option-card logout">Logout</a>
  </div>

    <div class="container">
        <h2>เพิ่มแผนก</h2>
        <form method="POST" action="add_category.php">
            <label>ชื่อแผนก:</label>
            <input type="text" name="name" required>
            <button type="submit" name="add_category">submit</button>
        </form>
    </div>
</body>
</html>
