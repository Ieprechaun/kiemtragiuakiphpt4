<?php
session_start();
include 'config/connect.php'; // Kết nối đến cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu
    $username = $_POST['username'];
    $password = $_POST['password']; // Bạn cần mã hóa mật khẩu ở đây

    // Kiểm tra xem tài khoản và mật khẩu có khớp không
    $check_user_query = "SELECT * FROM User WHERE username='$username' AND password='$password' LIMIT 1";
    $result = $conn->query($check_user_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // Nếu thông tin đăng nhập đúng
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];
        header('location: index.php'); // Chuyển hướng đến trang index.php
    } else {
        echo "Thông tin đăng nhập không chính xác";
    }
}
?>
<!-- Biểu mẫu HTML cho trang đăng nhập -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Đăng nhập</h2>
    <form action="login.php" method="POST">
        <label for="username">Tên đăng nhập:</label><br>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Mật khẩu:</label><br>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Đăng nhập">
        
    </form>
      <!-- Nút để chuyển đến trang đăng ký -->
      <form action="register.php" method="GET">
        <input type="submit" value="Đăng ký">
    </form>
</body>
</html>
