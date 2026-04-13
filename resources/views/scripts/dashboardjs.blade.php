{{-- Number of Student per colleges --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    const ctx = document.getElementById('collegesPieChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($collegelabels),
            datasets: [{
                data: @json($collegedata),
                backgroundColor: @json($collegecolors),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let value = context.raw;
                            let percent = ((value / total) * 100).toFixed(1);
                            return context.label + ': ' + value + ' (' + percent + '%)';
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