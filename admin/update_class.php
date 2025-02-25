<?php
include 'include/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = intval($_POST['class_id']);
    $class_name = $_POST['class_name'];
    $unit = $_POST['unit'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $update_query = "UPDATE classes SET 
        class_name = '$class_name', 
        unit = '$unit', 
        start_time = '$start_time', 
        end_time = '$end_time' 
        WHERE id = $class_id";

    if ($conn->query($update_query)) {
        header('Location: manage_classes.php');
    } else {
        echo "Error updating class: " . $conn->error;
    }
}
?>
