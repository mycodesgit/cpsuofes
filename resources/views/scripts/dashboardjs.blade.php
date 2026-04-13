<script>
/* =========================
   GLOBAL VARIABLES
========================= */
let barChart;
let pieChart;
let dataTable;

/* =========================
   INITIALIZE CHARTS
========================= */
document.addEventListener("DOMContentLoaded", function () {

    /* ===== PIE CHART ===== */
    const pieCtx = document.getElementById('collegesPieChart').getContext('2d');

    pieChart = new Chart(pieCtx, {
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
            cutout: '60%'
        }
    });

    /* ===== BAR CHART ===== */
    const barCtx = document.getElementById('departmentBarChart').getContext('2d');

    barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Colleges',
                data: @json($data),
                backgroundColor: @json($collegecolors),
                borderRadius: 5,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

});

$(document).ready(function() {
    dataTable = $('#evalresponseTable').DataTable({
        ajax: {
            url: dashevalresponseReadRoute,
            type: "GET",
            data: function(d) {
                d.campus = $('#campus').val();
                d.ratingperiod = $('#ratingperiod').val();
            }
        },
        destroy: true,
        info: true,
        responsive: true,
        lengthChange: true,
        searching: true,
        paging: true,
        order: [[1, "asc"]],
        columns: [
            {data: null, render: function(data, type, row, meta) { return meta.row + 1; }},
            {data: 'progCod'},
            {data: 'program'},
            {data: 'count'},
        ]
    });

});


/* =========================
   AJAX FILTER (SEARCH)
========================= */
$('#filterForm').on('submit', function(e) {
    e.preventDefault();

    let campus = $('#campus').val();
    let ratingperiod = $('#ratingperiod').val();

    if (!campus || !ratingperiod) {
        alert('Please select Campus and Rating Period');
        return;
    }

    $.ajax({
        url: "{{ route('dashboard.filter') }}",
        type: "GET",
        data: {
            campus: campus,
            ratingperiod: ratingperiod
        },

        beforeSend: function() {
            // Optional loading
            $('#facultyCount').text('...');
            $('#studentCount').text('...');
            $('#responseCount').text('...');
        },

        success: function(res) {

            /* ===== UPDATE CARDS ===== */
            $('#facultyCount').text(res.currfacultySched);
            $('#studentCount').text(res.currenrolled);
            $('#responseCount').text(res.currresponses);

            /* ===== UPDATE BAR CHART ===== */
            if (barChart) {
                barChart.data.labels = res.labels;
                barChart.data.datasets[0].data = res.data;
                barChart.update();
            }

            /* ===== UPDATE PIE CHART (if included in response) ===== */
            if (pieChart && res.collegelabels) {
                pieChart.data.labels = res.collegelabels;
                pieChart.data.datasets[0].data = res.collegedata;
                pieChart.update();
            }

            /* ===== RELOAD DATATABLE ===== */
            if (dataTable) {
                dataTable.ajax.reload();
            }

        },

        error: function(err) {
            console.log(err);
            alert('Something went wrong');
        }
    });
});


/* =========================
   AUTO SEARCH (OPTIONAL)
========================= */
// $('#campus, #ratingperiod').change(function() {
//     $('#filterForm').submit();
// });
</script>