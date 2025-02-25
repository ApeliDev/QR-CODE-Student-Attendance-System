<?php
session_start(); 

include('admin/include/db_connection.php');

// Validate class_id from the URL
if (!isset($_GET['class_id']) || empty($_GET['class_id'])) {
    echo "Invalid class ID.";
    header("Location: student_login.php");
    exit();
}

$class_id = intval($_GET['class_id']);

// Fetch class details
$query = "SELECT * FROM classes WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();
$class = $result->fetch_assoc();

// Check if the class exists
if (!$class) {
    echo "Class not found.";
    header("Location: student_login.php");
    exit();
}

// Render the attendance form and process submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get student registration number
    $reg_number = trim($_POST['reg_number']);

    if (empty($reg_number)) {
        echo "Registration number is required.";
    } else {
        // Fetch student details
        $stmt = $conn->prepare("SELECT id, first_name, last_name FROM students WHERE reg_number = ?");
        $stmt->bind_param("s", $reg_number);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();

        if (!$student) {
            echo "Invalid registration number.";
        } else {
            $student_id = $student['id'];
            $student_name = $student['first_name'] . " " . $student['last_name'];

            // Store student in the sessiom
            $_SESSION['student_name'] = $student_name;
            $_SESSION['student_id'] = $student_id;
           

            // Check if attendance already exists for this class and day
            $stmt = $conn->prepare(
                "SELECT id 
                 FROM attendance 
                 WHERE student_id = ? 
                   AND class_id = ? 
                   AND DATE(attendance_time) = CURDATE()"
            );
            $stmt->bind_param("ii", $student_id, $class_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "Attendance already marked for today.";
            } else {
                // Insert attendance into the database
                $stmt = $conn->prepare(
                    "INSERT INTO attendance (student_id, class_id, class_start_time, attendance_time, status) 
                     VALUES (?, ?, ?, NOW(), 'present')"
                );
                $stmt->bind_param("iis", $student_id, $class_id, $class['start_time']);

                if ($stmt->execute()) {
                    echo "Attendance recorded successfully.";
                    header("Location: students/dashboard.php");
                    exit();
                } else {
                    echo "Error recording attendance.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="css/record_attendance.css">
</head>
<body>
    <h1>Mark Attendance for <?php echo htmlspecialchars($class['class_name']); ?></h1>
    <form method="POST" action="">
        <label for="reg_number">Registration Number:</label>
        <input type="text" id="reg_number" name="reg_number" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
