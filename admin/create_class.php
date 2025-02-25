<?php
// Include the database connection
include('include/db_connection.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the class details from the form
    $class_name = $_POST['class_name'];
    $unit = $_POST['unit'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Set the attendance deadline to the class end time (or a little after)
    $attendance_deadline = $end_time;  
    
    // Insert the class into the database
    $query = $conn->prepare("INSERT INTO classes (class_name, unit, start_time, end_time, attendance_deadline) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("sssss", $class_name, $unit, $start_time, $end_time, $attendance_deadline);
    
    if ($query->execute()) {
        $class_id = $query->insert_id;

        // Generate the URL with class details for the QR code, adding the class_id and attendance_deadline
        $class_url = "https://localhost/KCA-attendance/record_attendance.php?class_id=" . $class_id . 
                     "&class_name=" . urlencode($class_name) . 
                     "&unit=" . urlencode($unit) . 
                     "&deadline=" . urlencode($attendance_deadline);

        // QR code generation API
        $apiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($class_url);

        // qr code folder
        $qr_directory = 'qrcodes';

        // Check if folder exists, if not create it
        if (!is_dir($qr_directory)) {
            mkdir($qr_directory, 0777, true);
        }

        // Set the path 
        $qrFile = $qr_directory . '/class_' . $class_id . '.png';

        // Use file_get_contents to fetch the QR code image from the API
        $imageData = file_get_contents($apiUrl);

        // Save the image to server
        file_put_contents($qrFile, $imageData);

        // Save the QR file path to database
        $update_query = $conn->prepare("UPDATE classes SET qr_code = ? WHERE id = ?");
        $update_query->bind_param("si", $qrFile, $class_id);
        $update_query->execute();

        //update the class status based on the class end time
        if (strtotime($end_time) < time()) {
            // If the class has ended, update its status
            $update_status_query = $conn->prepare("UPDATE classes SET status = 'ended' WHERE id = ?");
            $update_status_query->bind_param("i", $class_id);
            $update_status_query->execute();
        }
            echo "<script>
            alert('Class created successfully! QR code generated.');
            window.location.href = 'manage_classes.php'; 
        </script>";
    } else {
        $errorMessage = addslashes($query->error); 
        echo "<script>
            alert('Error creating class: $errorMessage');
            window.location.href = 'manage_classes.php'; 
        </script>";
    }
}
?>
