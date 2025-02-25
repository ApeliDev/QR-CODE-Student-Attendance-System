<?php
include('include/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $reg_number = mysqli_real_escape_string($conn, $_POST['reg_number']);
    
    // Validate inputs
    if (empty($first_name) || empty($last_name) || empty($email) || empty($reg_number)) {
        echo "All fields are required.";
    } else {
        // Insert student into the database 
        $sql = "INSERT INTO students (first_name, last_name, email, phone, reg_number) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $email, $phone, $reg_number);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "New student record created successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }
}

?>
