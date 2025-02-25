const ctx = document.getElementById('attendanceChart').getContext('2d');

const attendanceChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Present', 'Absent'],
        datasets: [{
            data: [18, 2], // Static data for now
            backgroundColor: ['#28a745', '#dc3545'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            }
        }
    }
});
