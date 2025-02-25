<?php include('include/auth.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .no-records {
            font-size: 18px;
            color: #e74c3c;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include('include/sidebar.php'); ?>
    <div class="main-content">
        <?php include('include/header.php'); ?>

        <div class="dashboard">
            <h2>My Attendance Records</h2>
            
            <?php
            include('../admin/include/db_connection.php');

            // Get the logged-in student ID from the session
            $student_id = $_SESSION['student_id'];

            // Query to fetch attendance records for the logged-in student
            $sql = "
                SELECT 
                    c.class_name,
                    c.unit,
                    a.class_start_time,
                    a.attendance_time,
                    a.status
                FROM 
                    attendance a
                JOIN 
                    classes c ON a.class_id = c.id
                WHERE 
                    a.student_id = ?
                ORDER BY 
                    a.attendance_time DESC;
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Output the attendance data in a table format
                echo "<table>";
                echo "<tr>
                        <th>Class</th>
                        <th>Unit</th>
                        <th>Start Time</th>
                        <th>Attendance Time</th>
                        <th>Status</th>
                      </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['class_name']}</td>
                            <td>{$row['unit']}</td>
                            <td>{$row['class_start_time']}</td>
                            <td>{$row['attendance_time']}</td>
                            <td>{$row['status']}</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                // If no records are found, display a message
                echo "<p class='no-records'>No attendance records found.</p>";
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
