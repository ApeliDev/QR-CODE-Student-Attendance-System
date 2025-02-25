<?php
include 'admin/include/db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Thank you for contacting us. Your message has been sent.'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Error submitting your message. Please try again.'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement. Please try again.'); window.history.back();</script>";
    }

    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>
