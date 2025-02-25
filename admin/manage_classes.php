<?php include ('include/auth.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes - Admin Panel</title>
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

                // Fclasses from the database
                $sql = "SELECT id, class_name, unit, start_time, end_time, status FROM classes ORDER BY start_time DESC";
                $result = $conn->query($sql);
                $classes = [];

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $classes[] = $row;
                    }
                }

                // delete request
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_class_id'])) {
                    $delete_id = intval($_POST['delete_class_id']);
                    $delete_query = "DELETE FROM classes WHERE id = $delete_id";
                    $conn->query($delete_query);
                    header('Location: manage_classes.php');
                    exit;
                }

                // edit
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_class_id'])) {
                    $edit_id = intval($_POST['edit_class_id']);
                    $edit_query = "SELECT * FROM classes WHERE id = $edit_id";
                    $edit_result = $conn->query($edit_query);
                    $edit_class = $edit_result->fetch_assoc();
                }
                ?>


                <h2>Class Management</h2>
                <p>View, edit, or add classes below.</p>

                <!-- Add Class Button -->
                <div class="action-bar">
                    <button class="btn btn-primary" id="open-modal"><i class="fas fa-plus"></i> Add New Class</button>
                </div>

                <!-- Class List -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>Unit</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($classes)): ?>
                            <?php foreach ($classes as $class): ?>
                                <tr>
                                    <td><?= htmlspecialchars($class['class_name']); ?></td>
                                    <td><?= htmlspecialchars($class['unit']); ?></td>
                                    <td><?= htmlspecialchars($class['start_time']); ?></td>
                                    <td><?= htmlspecialchars($class['end_time']); ?></td>
                                    <td>
                                        <span class="status <?= $class['status'] == 'active' ? 'active' : 'ended'; ?>">
                                            <?= ucfirst($class['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Edit Button -->
                                        <form method="POST" action="manage_classes.php" style="display:inline;">
                                            <input type="hidden" name="edit_class_id" value="<?= $class['id']; ?>">
                                            <button type="submit" class="btn btn-small btn-edit"><i class="fas fa-edit"></i> Edit</button>
                                        </form>
                                        <!-- Delete Button -->
                                        <form method="POST" action="manage_classes.php" style="display:inline;">
                                            <input type="hidden" name="delete_class_id" value="<?= $class['id']; ?>">
                                            <button type="submit" class="btn btn-small btn-delete" onclick="return confirm('Are you sure you want to delete this class?');">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No classes found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
    <!-- Modal -->
    <div id="class-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Class</h2>
                <button class="close" id="close-modal">&times;</button>
            </div>
            <form method="POST" action="create_class.php">
                <label for="class_name">Class Name:</label>
                <input type="text" id="class_name" name="class_name" required>
                
                <label for="unit">Unit:</label>
                <input type="text" id="unit" name="unit" required>

                <label for="start_time">Start Time:</label>
                <input type="datetime-local" id="start_time" name="start_time" required>

                <label for="end_time">End Time:</label>
                <input type="datetime-local" id="end_time" name="end_time" required>

                <input type="submit" value="Create Class">
            </form>
        </div>
    </div>                
    <!-- Edit Modal -->
    <?php if (isset($edit_class)): ?>
    <div id="edit-modal" class="modal" style="display:block;">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Class</h2>
                <button class="close" onclick="document.getElementById('edit-modal').style.display='none';">&times;</button>
            </div>
            <form method="POST" action="update_class.php">
                <input type="hidden" name="class_id" value="<?= $edit_class['id']; ?>">

                <label for="class_name">Class Name:</label>
                <input type="text" id="class_name" name="class_name" value="<?= htmlspecialchars($edit_class['class_name']); ?>" required>

                <label for="unit">Unit:</label>
                <input type="text" id="unit" name="unit" value="<?= htmlspecialchars($edit_class['unit']); ?>" required>

                <label for="start_time">Start Time:</label>
                <input type="datetime-local" id="start_time" name="start_time" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($edit_class['start_time']))); ?>" required>

                <label for="end_time">End Time:</label>
                <input type="datetime-local" id="end_time" name="end_time" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($edit_class['end_time']))); ?>" required>

                <input type="submit" value="Update Class">
            </form>
        </div>
    </div>
    <?php endif; ?>


    <script>
        // Modal JavaScript
        const modal = document.getElementById('class-modal');
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
