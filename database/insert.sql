CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('superadmin', 'admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- Insert an admin user wih hashed pswd
INSERT INTO admin_users (username, email, password_hash, role)
VALUES (
    'apelitech', 
    'livingstoneapeli@gmail.com', 
    '$2y$10$Bb7JIKEc1HAa4oeJ1DBEEOhenhPmgPvLKpBJ6twJuACIoskZTLziC',
    'superadmin'
);
