<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'employee') {
    header("Location: index.php");
    exit();
}

$categories = $conn->query("SELECT * FROM categories");

$category_id = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT * FROM products";
if ($category_id) {
    $sql .= " WHERE category_id='$category_id'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>ระบบแจ้งซ่อม</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 240px;
      background-color:rgb(51, 51, 51);
      color: white;
      padding: 20px;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 10px;
      margin-bottom: 5px;
    }
    .sidebar a:hover {
      background-color:rgb(116, 113, 113);
      border-radius: 5px;
    }
    .main {
      flex: 1;
      background-color: #ecf0f1;
      padding: 20px;
    }
    .table td, .table th {
      vertical-align: middle;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="mb-4 text-center">
      <img src="https://i.pravatar.cc/80" class="rounded-circle mb-2" alt="User">
      <p>Welcome!!!</p>
      <span class="badge bg-success">Online</span>
    </div>
    <a href="#">จัดการแจ้งซ่อม</a>
    <a href="#">ตรวจสอบสถานะ</a>
    <a href="#">ออกจากระบบ</a>
  </div>

  <!-- Main Content -->
  <div class="main">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>รายการแจ้งซ่อม</h2>
      <button class="btn btn-primary">+ แจ้งซ่อมใหม่</button>
    </div>

    <table class="table table-bordered table-hover bg-white">
      <thead class="table-light">
        <tr>
          <th>รหัส</th>
          <th>ผู้แจ้ง</th>
          <th>อุปกรณ์</th>
          <th>ปัญหา</th>
          <th>วันที่</th>
          <th>สถานะ</th>
          <th>จัดการ</th>
        </tr>
      </thead>
      <tbody>
        
      </tbody>
    </table>
  </div>

</body>
</html>
