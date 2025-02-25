<?php
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "student_attendance"; 

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // echo "Connected successfully"; 
}
?>
