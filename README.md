# 📸 QR Code Student Attendance System

A web-based QR Code Student Attendance System built using PHP, JavaScript, and CSS. This system allows institutions to track student attendance efficiently by combining manual input with QR code scanning, and includes logic to restrict attendance based on class timing.

## 🚀 Features

- 🧑‍🎓 **Student Registration:** Capture student details, including a unique registration number.
- 🏫 **Class Scheduling:** Register classes with specific start and end times.
- 📲 **QR Code Scanning:** Students enter their registration number, then scan their QR code to mark attendance.
- ⏰ **Time-Based Attendance Validation:** Attendance is only recorded if the scan is done within the scheduled class time.
- 📊 **Attendance Logging:** Accurate timestamps are logged for each entry.
- 📤 **Export Options:** Attendance data can be exported to CSV for reporting.
- 🔐 **Simple Admin Panel:** Secure login to manage students, classes, and view attendance.

## 💻 Technologies Used

- **PHP** – Backend logic and database integration
- **JavaScript** – QR code scanning and front-end interactivity
- **CSS** – Styling and responsive layout
- **HTML** – Page structure
- **MySQL** -For database
- **QR Code Libraries** – For generating and scanning QR codes (e.g., QR Server)

## 📷 How It Works

1. **Student & Class Setup**
   - Admin registers each student, capturing their full name and registration number.
   - The system generates a unique QR code for each student.
   - Admin also registers classes, specifying the subject and the scheduled start and end time.

2. **Attendance Process**
   - When a student enters the class, they:
     1. Enter their registration number into the system.
     2. Are redirected to a QR scan interface.
     3. Scan their QR code using a webcam or phone camera.
   - The system:
     - Validates the student and the class session.
     - Checks whether the scan was done within the valid time window.
     - If valid, marks the student as present and stores the timestamp.
     - If the scan is too late, attendance is not recorded.

3. **Admin Access**
   - Admins can log in to:
     - View and manage student and class data
     - View attendance logs

---
## 📞 Contact Information  
Need help? Reach out to us!  

📧 **Email:** [apelinifa@gmail.com](mailto:apelinifagmail.com)  
📱 **Phone:** [+254 743161167](tel:+254743161167)  


## 👨‍💻 Author
**Apeli** 🚀

---

## 🐝 License
This project is licensed under the MIT License.


    


