<?php include('include/auth.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="admin-panel">
        <?php include('include/sidebar.php'); ?>
        <div class="main-content">
            <?php include('include/header.php'); ?>
            <section class="dashboard">

                <?php
                    include('include/db_connection.php');

                    // Fetch total classes
                    $query_classes = "SELECT COUNT(*) AS total_classes FROM classes WHERE status = 'active'";
                    $result_classes = mysqli_query($conn, $query_classes);
                    $total_classes = mysqli_fetch_assoc($result_classes)['total_classes'];

                    // Fetch total students
                    $query_students = "SELECT COUNT(*) AS total_students FROM students";
                    $result_students = mysqli_query($conn, $query_students);
                    $total_students = mysqli_fetch_assoc($result_students)['total_students'];

                    // Fetch today's attendance
                    $query_attendance = "SELECT COUNT(*) AS attendance_today 
                                        FROM attendance 
                                        WHERE DATE(attendance_time) = CURDATE() 
                                        AND status = 'present'";
                    $result_attendance = mysqli_query($conn, $query_attendance);
                    $attendance_today = mysqli_fetch_assoc($result_attendance)['attendance_today'];
                ?>
                <h2>Admin Dashboard</h2>
                <p>Manage your classes, students, and attendance records here.</p>
                <div class="dashboard-widgets">
                    <div class="widget">
                        <h3>Total Classes</h3>
                        <p><?php echo $total_classes; ?></p>
                    </div>
                    <div class="widget">
                        <h3>Registered Students</h3>
                        <p><?php echo $total_students; ?></p>
                    </div>
                    <div class="widget">
                        <h3>Attendance Today</h3>
                        <p><?php echo $attendance_today; ?></p>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script src="js/admin-panel.js"></script>
</body>
</html>
