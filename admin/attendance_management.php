<?php include ('include/auth.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Attendance Management</title>
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

    <div class="admin-panel">
        <?php include('include/sidebar.php'); ?>
        <!-- Main Content -->
        <div class="main-content">
            <?php include('include/header.php'); ?>

            <section class="attendance-management">
                <?php                  
                    include('include/db_connection.php');

                    // Query to fetch attendance records
                    $sql = "
                        SELECT 
                            a.id AS attendance_id,
                            s.first_name,
                            s.last_name,
                            c.class_name,
                            c.unit,
                            a.class_start_time,
                            a.attendance_time,
                            a.status
                        FROM 
                            attendance a
                        JOIN 
                            students s ON a.student_id = s.id
                        JOIN 
                            classes c ON a.class_id = c.id
                        ORDER BY 
                            a.attendance_time DESC;
                    ";

                    $result = $conn->query($sql);
                ?>
                <h2>Attendance Management</h2>
                
                <?php
                if ($result->num_rows > 0) {
                    // Output the attendance data in a table format
                    echo "<table>";
                    echo "<tr>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Unit</th>
                            <th>Start Time</th>
                            <th>Attendance Time</th>
                            <th>Status</th>
                          </tr>";

                    // Fetch and display each row of attendance data
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['first_name']} {$row['last_name']}</td>
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
                ?>

            </section>
        </div>
    </div>

    <script src="js/admin-panel.js"></script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
