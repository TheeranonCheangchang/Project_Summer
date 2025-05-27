<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
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
  <link rel="stylesheet" href="sidebar_menu\sidebar.css">
  <style>
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
  </style>
</head>
<body>
  <?php include 'sidebar_menu\sidebar.php'; ?>
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
                    <td><a href="edit_repair.php?id=<?= $row['id'] ?>">แก้ไขข้อมูล</a></td>
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
