<?php
include('include/db_connection.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $reg_number = mysqli_real_escape_string($conn, $_POST['reg_number']);
    
    // Validate inputs
    if (empty($student_id) || empty($first_name) || empty($last_name) || empty($email) || empty($reg_number)) {
        echo "All fields are required.";
    } else {
        // Update student record in the database using prepared statements
        $sql = "UPDATE students SET 
                first_name = ?, 
                last_name = ?, 
                email = ?, 
                phone = ?, 
                reg_number = ? 
                WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssi", $first_name, $last_name, $email, $phone, $reg_number, $student_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Student record updated successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }
}
?>
