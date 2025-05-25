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

    $stmt = $conn->prepare("INSERT INTO repairs (device_code, device_name, problem, phone, repair_date, note)
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $device_code, $device_name, $problem, $phone, $repair_date, $note);

    if ($stmt->execute()) {
        echo "✅ แจ้งซ่อมสำเร็จ";
    } else {
        echo "❌ เกิดข้อผิดพลาด: " . $stmt->error;
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
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ddd;
            text-align: center;
            margin: 0;
            padding: 0;
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
