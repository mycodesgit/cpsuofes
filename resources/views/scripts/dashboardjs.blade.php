{{-- Performance Distribution --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('performancePieChart').getContext('2d');

        const performancePieChart = new Chart(ctx, {
            type: 'doughnut', // use 'pie' if you want full pie
            data: {
                // labels: [
                //     'Always manifested (5)',
                //     'Often manifested (4)',
                //     'Sometimes manifested (3)',
                //     'Seldom manifested (2)',
                //     'Never/Rarely manifested (1)'
                // ],
                datasets: [{
                    data: [50, 25, 13, 8, 4], // replace with dynamic data
                    backgroundColor: [
                        '#28a745', // green
                        '#6ab04c',
                        '#f6c23e',
                        '#f39c12',
                        '#e74c3c'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%', // makes it donut style
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',   // ✅ move to right
                        align: 'center',     // center vertically
                        labels: {
                            boxWidth: 12,
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    });
</script>

{{-- Department Summary --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('departmentBarChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: deptLabels,
                datasets: [{
                    label: 'Total Classes',
                    data: deptData,
                    backgroundColor: [
                        '#108d6d', // green
                        '#ed2e40',
                        '#e83e8c',
                        '#6610f2',
                        '#6c757d',
                        '#fd7e14',
                        '#007bff'
                    ],
                    borderRadius: 5,
                    barThickness: 30
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5
                        }
                    }
                }
            }
        });
    });
</script>