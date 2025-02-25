<?php
// Include the database connection
include('admin/include/db_connection.php');

// Fetch the most recent class details (for the QR code)
$query = "SELECT * FROM classes ORDER BY start_time DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$class = mysqli_fetch_assoc($result);

// Check if the class exists
if (!$class) {
    // Class not found
    echo "Class not found.";
    header("Location: student_login.php");
    exit();
}

// Get current time and compare with class start and end time
$current_time = date("Y-m-d H:i:s");
$start_time = $class['start_time'];
$end_time = $class['end_time'];

// Check if the class has ended
if ($current_time > $end_time) {
    echo "Class has already ended.";
    header("Location: student_login.php");
    exit();
}

// Calculate the 20 minutes grace period after the class starts
$grace_period_end = date("Y-m-d H:i:s", strtotime($start_time) + 20 * 60);

// Check if the student is late (more than 20 minutes after the class has started)
if ($current_time > $grace_period_end) {
    echo "You are late for the class.";
    header("Location: student_login.php");
    exit();
}

// If all checks pass, show the QR code
$qr_code = $class['qr_code'];
$qr_image_path = 'admin/' . htmlspecialchars($qr_code);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Login</title>
    <link rel="stylesheet" href="css/qr-login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
</head>
<body>
    <header class="qr-header">
        <nav class="navbar container">
            <div class="logo">
                <h1>AttendancePro</h1>
            </div>
        </nav>
        <div class="qr-hero-content container">
            <h1 class="hero-title">Scan QR Code to Login</h1>
            <p class="hero-subtitle">Ensure you scan the valid QR code provided for your class attendance.</p>
        </div>
    </header>

    <main class="qr-main">
        <section class="qr-scanner-section container">
            <h2>QR Code Scanner</h2>
            <div id="qr-reader" class="qr-reader">
                <?php if (isset($qr_code)): ?>
                    <img src="<?= $qr_image_path ?>" alt="QR Code for Class Attendance" />
                <?php else: ?>
                    <p>QR code not available for this class.</p>
                <?php endif; ?>
            </div>
            <div id="qr-reader-interface" class="qr-reader-interface">
                <div id="qr-reader-results" class="qr-reader-results">
                    <p>Scan a QR code to mark your attendance.</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2024 AttendancePro | All Rights Reserved</p>
        </div>
    </footer>

    <script>
        // Initialize the QR code scanner
        const qrReader = new Html5Qrcode("qr-reader");

        function onScanSuccess(decodedText, decodedResult) {
            try {
                const url = new URL(decodedText);
                const classId = url.searchParams.get('class_id');
                const className = url.searchParams.get('class_name');
                const startTime = url.searchParams.get('start_time');
                const endTime = url.searchParams.get('end_time');

                // Redirect the user to the attendance form with the class details in the URL
                if (classId) {
                    window.location.href = `record_attendance.php?class_id=${classId}&class_name=${encodeURIComponent(className)}&start_time=${encodeURIComponent(startTime)}&end_time=${encodeURIComponent(endTime)}`;
                } else {
                    alert("Invalid QR Code.");
                }
            } catch (error) {
                console.error("Invalid QR Code format.", error);
                alert("Failed to parse QR Code.");
            }
        }

        function onScanFailure(error) {
            console.warn(`QR Scan Failed: ${error}`);
        }

        // Start the scanner
        qrReader.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            onScanSuccess,
            onScanFailure
        );
    </script>

</body>
</html>
