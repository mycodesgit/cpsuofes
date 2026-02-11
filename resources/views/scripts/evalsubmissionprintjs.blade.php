<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-left"
    };
    $(document).ready(function() {

        var urlParams = new URLSearchParams(window.location.search);
        var schlyear = urlParams.get('schlyear') || ''; 
        var semester = urlParams.get('semester') || '';
        var campus = urlParams.get('campus') || ''; 
        var progCod = urlParams.get('progCod') || '';

        var dataTable = $('#submitevalTable').DataTable({
            "ajax": {
                "url": submissionReadRoute,
                "type": "GET",
                "data": { 
                    "schlyear": schlyear,
                    "semester": semester,
                    "campus": campus,
                    "progCod": progCod
                }
            },
            destroy: true,
            info: true,
            responsive: true,
            lengthChange: true,
            searching: true,
            paging: true,
            "columns": [
                {data: 'evaluatorname'},
                {data: 'qcefacname'},
                {
                    data: 'campus',
                    render: function(data, type, row) {
                        if (data == 'MC') {
                            return 'Main';
                        } else if (data == 'VC') {
                            return 'Victorias';
                        } else if (data == 'SCC') {
                            return 'San Carlos';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return `
                                <button class="btn btn-success text-light btn-sm btn-viewpdf"
                                    data-id="${row.id}"  
                                    data-program="${row.progCod}" 
                                    data-year="${row.studYear}" 
                                    data-section="${row.studSec}" 
                                    data-schlyear="${row.schlyear}" 
                                    data-semester="${row.semester}" 
                                    data-campus="${row.campus}" 
                                    data-studidno="${row.studidno}" 
                                    title="View PDF">
                                    <i class="fas fa-print"></i>
                                </button>`;
                        } else {
                            return data;
                        }
                    }
                }
            ],
            "createdRow": function (row, data, index) {
                $(row).attr('id', 'tr-' + data.fctyid); 
            }
        });
        setInterval(function () {
            dataTable.ajax.reload(null, false);
        }, 3000);
    });

    $(document).ready(function() {

        var urlParams = new URLSearchParams(window.location.search);
        var schlyear = urlParams.get('schlyear') || ''; 
        var semester = urlParams.get('semester') || '';
        var campus = urlParams.get('campus') || ''; 
        var progCod = urlParams.get('progCod') || '';

        var dataTable = $('#doneprintTable').DataTable({
            "ajax": {
                "url": doneprintReadRoute,
                "type": "GET",
                "data": { 
                    "schlyear": schlyear,
                    "semester": semester,
                    "campus": campus,
                    "progCod": progCod
                }
            },
            destroy: true,
            info: true,
            responsive: true,
            lengthChange: true,
            searching: true,
            paging: true,
            "columns": [
                {data: 'evaluatorname'},
                {data: 'qcefacname'},
                {
                    data: 'campus',
                    render: function(data, type, row) {
                        if (data == 'MC') {
                            return 'Main';
                        } else if (data == 'VC') {
                            return 'Victorias';
                        } else if (data == 'SCC') {
                            return 'San Carlos';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return `
                                <button class="btn btn-primary btn-sm btn-viewdonepdf"
                                    data-id="${row.id}"  
                                    data-program="${row.progCod}" 
                                    data-year="${row.studYear}" 
                                    data-section="${row.studSec}" 
                                    data-schlyear="${row.schlyear}" 
                                    data-semester="${row.semester}" 
                                    data-campus="${row.campus}" 
                                    data-studidno="${row.studidno}" 
                                    title="View PDF">
                                    <i class="fas fa-eye"></i>
                                </button>`;
                        } else {
                            return data;
                        }
                    }
                }
            ],
            "createdRow": function (row, data, index) {
                $(row).attr('id', 'tr-' + data.fctyid); 
            }
        });
        setInterval(function () {
            dataTable.ajax.reload(null, false);
        }, 3000);
    });

    $(document).ready(function () {
        $('#submitevalTable').on('click', '.btn-viewpdf', function () {
            var id = $(this).data('id');
            var programCode = $(this).data('program');
            var studYear = $(this).data('year');
            var studSec = $(this).data('section');
            var schlyear = $(this).data('schlyear');
            var semester = $(this).data('semester');
            var campus = $(this).data('campus');
            var studidno = $(this).data('studidno');

            console.log({
                id, programCode, studYear, studSec, schlyear, semester, campus, studidno
            });

            if (!programCode || !studYear || !studSec || !schlyear || !semester || !campus || !studidno) {
                alert("Missing required data. Please check your inputs.");
                return;
            }

            var pdfUrl = `${studentevalsubPDFReadRoute}?id=${encodeURIComponent(id)}&progCod=${encodeURIComponent(programCode)}&studYear=${encodeURIComponent(studYear)}&studSec=${encodeURIComponent(studSec)}&schlyear=${encodeURIComponent(schlyear)}&semester=${encodeURIComponent(semester)}&campus=${encodeURIComponent(campus)}&studidno=${encodeURIComponent(studidno)}`;

            $('#pdfIframe').attr('src', pdfUrl);
            $('#viewEvalRatePDFId').val(id);
            $('#viewEvalRatePDFModal').modal('show');
        });

        $('#btnDonePrint').on('click', function (event) {
            event.preventDefault();
            var id = $('#viewEvalRatePDFId').val();

            $.ajax({
                url: studentevalsubPDFprintUpdateReadRoute,
                type: "POST",
                data: {
                    id: id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        $('#viewEvalRatePDFModal').modal('hide');
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error, message) {
                    var errorMessage = xhr.responseText ? JSON.parse(xhr.responseText).message : 'An error occurred';
                    toastr.error(errorMessage);
                }
            });
        });

        $('.btn-close-modal').on('click', function () {
            $('#viewEvalRatePDFModal').modal('hide');
        });
    });


    $(document).ready(function () {
        $('#doneprintTable').on('click', '.btn-viewdonepdf', function () {
            var id = $(this).data('id');
            var programCode = $(this).data('program');
            var studYear = $(this).data('year');
            var studSec = $(this).data('section');
            var schlyear = $(this).data('schlyear');
            var semester = $(this).data('semester');
            var campus = $(this).data('campus');
            var studidno = $(this).data('studidno');

            console.log({
                id, programCode, studYear, studSec, schlyear, semester, campus, studidno
            });

            if (!programCode || !studYear || !studSec || !schlyear || !semester || !campus || !studidno) {
                alert("Missing required data. Please check your inputs.");
                return;
            }

            var pdfUrl = `${studentevalsubPDFReadRoute}?id=${encodeURIComponent(id)}&progCod=${encodeURIComponent(programCode)}&studYear=${encodeURIComponent(studYear)}&studSec=${encodeURIComponent(studSec)}&schlyear=${encodeURIComponent(schlyear)}&semester=${encodeURIComponent(semester)}&campus=${encodeURIComponent(campus)}&studidno=${encodeURIComponent(studidno)}`;

            $('#pdfIframe').attr('src', pdfUrl);
            $('#viewEvalRatePDFId').val(id);
            $('#viewEvalRatePDFModal').modal('show');
        });

        $('.btn-close-modal').on('click', function () {
            $('#viewEvalRatePDFModal').modal('hide');
        });
    });
</script>