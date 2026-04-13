<script>
    let dataTable;
    $(document).ready(function() {
        var dataTable = $('#evalresponseTable').DataTable({
            "ajax": {
                "url": dashevalresponseReadRoute,
                "type": "GET",
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
            "order": [[1, "asc"]],
            "columns": [
                {data: null, render: function(data, type, row, meta) { return meta.row + 1; }},
                {data: 'progCod'},
                {data: 'program'},
                {data: 'count'},
            ],
            "createdRow": function (row, data, index) {
                $(row).attr('id', 'tr-' + data.id); 
            }
        });
    });
</script>