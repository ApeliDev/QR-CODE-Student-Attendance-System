<?php include ('include/auth.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/manage_classes.css">
</head>
<body>
    <div class="admin-panel">
        <!-- Sidebar -->
        <?php include('include/sidebar.php'); ?>
        <!-- Main Content -->
        <div class="main-content">
            <?php include('include/header.php'); ?>
            <section class="dashboard">
                <?php
                    include 'include/db_connection.php';

                    // Fetch students from the database
                    $sql = "SELECT id, first_name, last_name, email, phone, reg_number, created_at FROM students ORDER BY created_at DESC";
                    $result = $conn->query($sql);
                    $students = [];

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $students[] = $row;
                        }
                    }

                    // Delete request
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_student_id'])) {
                        $delete_id = intval($_POST['delete_student_id']);
                        $delete_query = "DELETE FROM students WHERE id = $delete_id";
                        $conn->query($delete_query);
                        header('Location: manage_students.php');
                        exit;
                    }

                    // Edit request
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_student_id'])) {
                        $edit_id = intval($_POST['edit_student_id']);
                        $edit_query = "SELECT * FROM students WHERE id = $edit_id";
                        $edit_result = $conn->query($edit_query);
                        $edit_student = $edit_result->fetch_assoc();
                    }
                ?>

                <h2>Student Management</h2>
                <p>View, edit, or add students below.</p>

                <!-- Add Student Button -->
                <div class="action-bar">
                    <button class="btn btn-primary" id="open-modal"><i class="fas fa-plus"></i> Add New Student</button>
                </div>

                <!-- Student List -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Reg Number</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($students)): ?>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?= htmlspecialchars($student['first_name']); ?></td>
                                    <td><?= htmlspecialchars($student['last_name']); ?></td>
                                    <td><?= htmlspecialchars($student['email']); ?></td>
                                    <td><?= htmlspecialchars($student['phone']); ?></td>
                                    <td><?= htmlspecialchars($student['reg_number']); ?></td>
                                    <td><?= htmlspecialchars($student['created_at']); ?></td>
                                    <td>
                                        <form method="POST" action="manage_students.php" style="display:inline;">
                                            <input type="hidden" name="edit_student_id" value="<?= $student['id']; ?>">
                                            <button type="submit" class="btn btn-small btn-edit"><i class="fas fa-edit"></i> Edit</button>
                                        </form>
                                        <form method="POST" action="manage_students.php" style="display:inline;">
                                            <input type="hidden" name="delete_student_id" value="<?= $student['id']; ?>">
                                            <button type="submit" class="btn btn-small btn-delete" onclick="return confirm('Are you sure you want to delete this student?');">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">No students found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Modal -->
                <div id="student-modal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Add New Student</h2>
                            <button class="close" id="close-modal">&times;</button>
                        </div>
                        <form method="POST" action="create_student.php">
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" required>

                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" required>

                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>

                            <label for="phone">Phone:</label>
                            <input type="text" id="phone" name="phone" required>

                            <label for="reg_number">Registration Number:</label>
                            <input type="text" id="reg_number" name="reg_number" required>

                            <input type="submit" value="Create Student">
                        </form>
                    </div>
                </div>

                <!-- Edit Modal -->
                <?php if (isset($edit_student)): ?>
                <div id="edit-modal" class="modal" style="display:block;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Edit Student</h2>
                            <button class="close" onclick="document.getElementById('edit-modal').style.display='none';">&times;</button>
                        </div>
                        <form method="POST" action="update_student.php">
                            <input type="hidden" name="student_id" value="<?= $edit_student['id']; ?>">

                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($edit_student['first_name']); ?>" required>

                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($edit_student['last_name']); ?>" required>

                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($edit_student['email']); ?>" required>

                            <label for="phone">Phone:</label>
                            <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($edit_student['phone']); ?>" required>

                            <label for="reg_number">Registration Number:</label>
                            <input type="text" id="reg_number" name="reg_number" value="<?= htmlspecialchars($edit_student['reg_number']); ?>" required>

                            <input type="submit" value="Update Student">
                        </form>
                    </div>
                </div>
                <?php endif; ?>

            </section>
        </div>
    </div>

    <script>
        // Modal JavaScript
        const modal = document.getElementById('student-modal');
        const openModal = document.getElementById('open-modal');
        const closeModal = document.getElementById('close-modal');

        openModal.addEventListener('click', () => {
            modal.style.display = 'block';
        });

        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
    </script>
</body>
</html>
