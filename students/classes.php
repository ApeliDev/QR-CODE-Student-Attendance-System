<?php include('include/auth.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Classes - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        table.table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }


        table.table thead {
            background-color: #007bff; 
            color: #fff;
        }

        table.table thead th {
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }


        table.table tbody tr {
            border-bottom: 1px solid #ddd;
        }

        table.table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table.table tbody td {
            padding: 10px;
            text-align: left;
            color: #333;
        }


        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .status.present {
            background-color: #28a745; 
            color: #fff;
        }

        .status.absent {
            background-color: #dc3545; 
            color: #fff;
        }
    </style>
</head>
<body>
    <?php include('include/sidebar.php'); ?>
    <div class="main-content">
        <?php include('include/header.php'); ?>
        <section class="dashboard">
            <?php
            include '../admin/include/db_connection.php';

            // Fetch classes and attendance
            $query = "
                SELECT 
                    c.id AS class_id, 
                    c.class_name, 
                    c.unit, 
                    c.start_time, 
                    c.end_time, 
                    a.status AS attendance_status
                FROM 
                    classes c
                LEFT JOIN 
                    attendance a 
                ON 
                    c.id = a.class_id 
                    AND a.student_id = ? 
                ORDER BY 
                    c.start_time DESC";
            
        
            $student_id = $_SESSION['student_id'];
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $classes = [];
            while ($row = $result->fetch_assoc()) {
                $classes[] = $row;
            }
            ?>
            <h2>Classes</h2>
            <p>Below is the list of classes. 
             Classes without attendance are marked as absent.</p>
            <p>Find the QR code to scan and mark the class attendance</p>

            <table class="table">
                <thead>
                    <tr>
                        <th>Class Name</th>
                        <th>Unit</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($classes)): ?>
                        <?php foreach ($classes as $class): ?>
                            <tr>
                                <td><?= htmlspecialchars($class['class_name']); ?></td>
                                <td><?= htmlspecialchars($class['unit']); ?></td>
                                <td><?= htmlspecialchars($class['start_time']); ?></td>
                                <td><?= htmlspecialchars($class['end_time']); ?></td>
                                <td>
                                    <?php if ($class['attendance_status'] === 'present'): ?>
                                        <span class="status present">Present</span>
                                    <?php else: ?>
                                        <span class="status absent">Absent</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No classes found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
    <script src="js/dashboard.js"></script>
</body>
</html>
