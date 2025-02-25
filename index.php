<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR-Based Student Attendance System</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include('include/header.php'); ?>
    <main>
        <section id="features" class="features-section container">
            <h2>Features</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-check-circle"></i>
                    <h3>Seamless Attendance</h3>
                    <p>Mark attendance instantly by scanning a QR code at the entrance.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Secure</h3>
                    <p>Attendance is recorded securely to ensure accuracy and reliability.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-chart-bar"></i>
                    <h3>Detailed Reports</h3>
                    <p>Admins can view attendance statistics for improved decision-making.</p>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section id="how-it-works" class="how-it-works-section">
            <div class="container">
                <h2>How It Works</h2>
                <ol>
                    <li>Students scan the QR code placed at the class entrance.</li>
                    <li>The system verifies the student and marks their attendance.</li>
                    <li>Attendance details are securely stored for future reporting.</li>
                </ol>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="contact-section">
            <div class="container">
                <h2>Contact Us</h2>
                <p>Have questions? Reach out to our support team for assistance.</p>
                <form action="contact.php" method="POST">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" placeholder="Your Message" required></textarea>
                    <button type="submit" class="btn"><i class="fas fa-paper-plane"></i> Send Message</button>
                </form>
            </div>
        </section>
    </main>
    <?php include('include/footer.php'); ?>
</body>
</html>
