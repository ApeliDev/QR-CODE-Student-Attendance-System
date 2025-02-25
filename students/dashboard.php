<?php include('include/auth.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php include('include/sidebar.php'); ?>
    <div class="main-content">
        <?php include('include/header.php'); ?>

        <?php
            include('../admin/include/db_connection.php');

            // session set in the login/during redirection
            $student_id = $_SESSION['student_id'];

            // Fetch total classes attended by the student
            $query_attended = "
                SELECT COUNT(*) AS attended_classes 
                FROM attendance 
                WHERE student_id = '$student_id' AND status = 'present'
            ";
            $result_attended = mysqli_query($conn, $query_attended);
            $attended_classes = mysqli_fetch_assoc($result_attended)['attended_classes'];

            // Fetch total classes
            $query_total_classes = "
                SELECT COUNT(*) AS total_classes 
                FROM classes 
                WHERE status = 'active'
            ";
            $result_total_classes = mysqli_query($conn, $query_total_classes);
            $total_classes = mysqli_fetch_assoc($result_total_classes)['total_classes'];

            // Calculate attendance percentage
            $attendance_percentage = $total_classes > 0 ? round(($attended_classes / $total_classes) * 100, 2) : 0;
        ?>

        <div class="dashboard">
            <h2>Overview</h2>
            <div class="dashboard-widgets">
                <div class="widget">
                    <h3>Total Classes</h3>
                    <p><?php echo $total_classes; ?></p>
                </div>
                <div class="widget">
                    <h3>Attendance</h3>
                    <p><?php echo $attendance_percentage; ?>%</p>
                </div>
                <div class="widget">
                    <h3>Assignments Due</h3>
                    <p>Feature Coming Soon</p>
                </div>
                <div class="widget">
                    <h3>Upcoming Exams</h3>
                    <p>Feature Coming Soon</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
