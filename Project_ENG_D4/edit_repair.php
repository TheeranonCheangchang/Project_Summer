<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin' && $_SESSION['user']['role'] != 'employee') {
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM repairs ORDER BY repair_date DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งรายละเอียดของซ่อม</title>
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
            width: 96%;
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
    <div class="sidebar">
            <img src="https://images.workpointtoday.com/workpointtv/2020/09/16045608/cropped-favicon.png" class="rounded-circle mb-2" alt="User">
            <a href="manage_users.php" class="option-card">จัดการผู้ใช้งาน</a>
            <a href="manage_category.php" class="option-card">จัดการแผนก</a>
            <a href="dashboard.php" class="option-card">รายการแจ้งซ่อม</a>
            <a href="logout.php" class="option-card logout">Logout</a>
    </div>
    
   <div class="main">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>รายการแจ้งซ่อม</h2>
      <a href="new_repair.php" class="option-card logout">+ แจ้งซ่อมใหม่</a>
    </div>

    <table class="table table-bordered table-hover bg-white">
      <thead class="table-light">
      <tr>
          <th>รหัส</th>
          <th>รหัสอุปกรณ์</th>
          <th>ชื่ออุปกรณ์</th>
          <th>ปัญหา</th>
          <th>วันที่แจ้ง</th>
          <th>หมายเหตุ</th>
          <th>สถานะ</th>
          <th>รายละเอียด</th>
      </tr>

      <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['device_code']) ?></td>
                    <td><?= htmlspecialchars($row['device_name']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['problem'])) ?></td>
                    <td><?= $row['repair_date'] ?></td>
                    <td><?= nl2br(htmlspecialchars($row['note'])) ?></td>
                    <td><span class="status <?= $row['status'] ?>"><?= ucfirst($row['status']) ?></span></td>
                    <td><a href="edit_repair.php" class="option-card logout">แก้ไขข้อมูล</a></button></td>
                  </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8" style="text-align:center;">ไม่มีข้อมูลแจ้งซ่อม</td></tr>
        <?php endif; ?>
      </tbody>
      </thead>
    </table>
  </div>
</body>
</html>
