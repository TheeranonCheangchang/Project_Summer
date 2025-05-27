<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'employee') {
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM repairs ORDER BY repair_date DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>ระบบแจ้งซ่อม</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    
    body {
      font-family: "Kanit", sans-serif;
      display: flex;
      min-height: 100vh;
    }
    
    .kanit-regular {
      font-family: "Kanit", sans-serif;
      font-weight: 300;
      font-style: normal;
    }
    
    .sidebar {
      width: 240px;
      background-color: rgb(72, 130, 255);
      color: white;
      padding: 20px;
    }

    .sidebar img {
      max-width: 80%;
      height: auto;
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
  </style>
</head>
<body>
  <div class="sidebar">
    <div class="mb-4 text-center">
      <img src="https://images.workpointtoday.com/workpointtv/2020/09/16045608/cropped-favicon.png" class="rounded-circle mb-2" alt="User">
    </div>
    <a href="new_repair_user.php" class="option-card logout">แจ้งซ่อมใหม่</a>
    <a href="logout.php" class="option-card logout">Logout</a>
  </div>

  <div class="main">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>รายการแจ้งซ่อม</h2>
    </div>

    <table class="table table-bordered table-hover bg-white">
      <thead class="table-light">
      <tr>
          <th>รหัส</th>
          <th>รหัสอุปกรณ์</th>
          <th>ชื่ออุปกรณ์</th>
          <th>ปัญหา</th>
          <th>เบอร์โทรศัพท์</th>
          <th>วันที่แจ้ง</th>
          <th>หมายเหตุ</th>
          <th>สถานะ</th>
      </tr>

      <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['device_code']) ?></td>
                    <td><?= htmlspecialchars($row['device_name']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['problem'])) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= $row['repair_date'] ?></td>
                    <td><?= nl2br(htmlspecialchars($row['note'])) ?></td>
                    <td><span class="status <?= $row['status'] ?>"><?= ucfirst($row['status']) ?></span></td>
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
