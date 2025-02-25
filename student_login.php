<?php
session_start(); 
include('admin/include/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email and registration number from form
    $email = trim($_POST['email']);
    $reg_number = trim($_POST['reg_number']);

    if (empty($email) || empty($reg_number)) {
        echo "Email and Registration Number are required.";
    } else {
        // Check the database for matching email and registration number
        $stmt = $conn->prepare("SELECT id, first_name, last_name FROM students WHERE email = ? AND reg_number = ?");
        $stmt->bind_param("ss", $email, $reg_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            
            $student = $result->fetch_assoc();

            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_name'] = $student['first_name'] . " " . $student['last_name'];
            $_SESSION['student_id'] = $student_id['id'];
          
            header("Location: students/dashboard.php");
            exit();
        } else {
            // Invalid credentials
            echo "Invalid email or registration number.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link rel="stylesheet" href="css/qr-login.css">
</head>
<body>
    <header class="qr-header">
        <nav class="navbar container">
            <div class="logo">
                <h1>AttendancePro</h1>
            </div>
        </nav>
        <div class="qr-hero-content container">
            <h1 class="hero-title">Student Login</h1>
            <p class="hero-subtitle">Log in to access your dashboard or try scanning the QR code again if a new class starts.</p>
        </div>
    </header>

    <main class="qr-main">
        <section class="login-section container">
            <h2>Login to Dashboard</h2>
            <form action="student_login.php" method="POST" class="login-form">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your Email" required>
                
                <label for="reg_number">Registration Number</label>
                <input type="text" id="reg_number" name="reg_number" placeholder="Enter your Registration Number" required>
                
                <button type="submit" class="btn-login">Login</button>
            </form>
        </section>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2024 AttendancePro | All Rights Reserved</p>
        </div>
    </footer>
</body>
</html>
