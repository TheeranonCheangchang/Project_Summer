<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

$category_result = mysqli_query($conn, "SELECT id, name FROM categories");

if (isset($_POST['register_employee'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

    if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/", $password)) {
        echo "<script>alert('Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, and one number.'); window.history.back();</script>";
        exit();
    }

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    $email_check = $conn->query("SELECT id FROM users WHERE email = '$email'");
    if ($email_check->num_rows > 0) {
        echo "<script>alert('Email already exists! Please use a different email.'); window.history.back();</script>";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, password, firstname, lastname, email, role, category_id)
            VALUES ('$username', '$hashed_password', '$firstname', '$lastname', '$email', 'employee', '$category_id')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Employee registered successfully!'); window.location='manage_users.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Employee</title>
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
            max-height: 900px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }
        h2 {
            margin-bottom: 20px;
        }
        select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 15px;
            text-align: center;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        form {
            padding-bottom: 20px;
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
        <div class="mb-4 text-center">
        <img src="https://images.workpointtoday.com/workpointtv/2020/09/16045608/cropped-favicon.png" class="rounded-circle mb-2" alt="User">
        </div>
        <a href="manage_users.php" class="option-card">จัดการผู้ใช้งาน</a>
        <a href="manage_category.php" class="option-card">จัดการแผนก</a>
        <a href="dashboard.php" class="option-card">การแจ้งซ่อม</a>
        <a href="logout.php" class="option-card logout">Logout</a>
    </div>

    <div class="container">
        <h2>Register Employee</h2>
        <form method="POST" action="register_employee.php">
            <label>Username:</label>
            <input type="text" name="username" required>
            
            <label>Password:</label>
            <input type="password" name="password" required pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}" title="Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, and one number.">
            
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required>
            
            <label>First Name:</label>
            <input type="text" name="firstname" required>
            
            <label>Last Name:</label>
            <input type="text" name="lastname" required>

            <label for="category_id">แผนก:</label>
            <select name="category_id" id="category_id" required>
                <option value="">-- เลือกแผนก --</option>
                <?php while ($cat = mysqli_fetch_assoc($category_result)) : ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endwhile; ?>
            </select>
            
            <label>Email:</label>
            <input type="email" name="email" required>
            
            <button type="submit" name="register_employee">Register</button>
        </form>
    </div>
</body>
</html>
