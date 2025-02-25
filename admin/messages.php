<?php
include 'include/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management Panel - Messages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/messages.css">
</head>
<body>
    <div class="admin-panel">
        <?php include('include/sidebar.php'); ?>
        <!-- Main Content -->
        <div class="main-content">
            <?php include('include/header.php'); ?>
            <section class="dashboard">
                <h2>Contact Messages</h2>
                <p>View all messages submitted by users through the contact form.</p>
                
                <div class="message-table">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Date Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('include/db_connection.php');

                            $sql = "SELECT id, name, email, message, submitted_at FROM contact_messages ORDER BY submitted_at DESC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $count = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$count}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['message']}</td>
                                        <td>{$row['submitted_at']}</td>
                                    </tr>";
                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='5'>No messages found.</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <script src="js/admin-panel.js"></script>
</body>
</html>
