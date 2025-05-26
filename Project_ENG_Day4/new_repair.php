<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin' && $_SESSION['user']['role'] != 'employee') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $device_code = $_POST['device_code'];
    $device_name = $_POST['device_name'];
    $problem = $_POST['problem'];
    $phone = $_POST['phone'];
    $repair_date = $_POST['repair_date'];
    $note = $_POST['note'];
    $user_id = $_SESSION['user']['id'] ?? null;
    $sql = "INSERT INTO repairs (device_code, device_name, problem, phone, repair_date, note, user_id)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $device_code, $device_name, $problem, $phone, $repair_date, $note, $user_id);
    if ($stmt->execute()) {
        echo "<script>alert('✅ แจ้งซ่อมสำเร็จ'); window.location='manage_category.php';</script>";
        exit();
    } else {
        echo "<script>alert('❌ เกิดข้อผิดพลาด: '); window.location='manage_category.php';</script>";
        exit();
    }
}

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
    <div class="container">
        <h2>แจ้งรายละเอียดของซ่อม</h2>
        <form method="POST" action="new_repair.php">
        <label>รหัสอุปกรณ์:</label>
         <input type="text" name="device_code" required><br>

        <label>ชื่ออุปกรณ์:</label>
        <input type="text" name="device_name" required><br>

        <label>ปัญหาที่พบ:</label>
        <input type="text" name="problem"><br>

        <label>เบอร์โทรศัพท์:</label>
        <input type="text" name="phone"><br>

        <label>วันที่แจ้งซ่อม:</label>
        <input type="date" name="repair_date" required><br>

        <label>หมายเหตุ:</label>
        <input type="text" name="note"><br>

        <button type="submit">แจ้งซ่อม</button>
        </form>
    </div>
</body>
</html>
