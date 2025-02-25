// Toggle sidebar
document.querySelector('.sidebar-toggle').addEventListener('click', () => {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('collapsed');
});

// Notification and profile button functionality
document.querySelector('.notification-btn').addEventListener('click', () => {
    alert('You have new notifications!');
});

document.querySelector('.profile-btn').addEventListener('click', () => {
    alert('Profile settings coming soon!');
});
