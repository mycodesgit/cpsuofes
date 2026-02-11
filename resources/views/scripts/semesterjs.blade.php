<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-left"
    };
    $(document).ready(function() {
        $('#addSemester').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: semesterCreateRoute,
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        console.log(response);
                        $(document).trigger('semesterAdded');
                        $('input[name="qceschlyear"]').val('');
                        $('textarea[name="qcesemester"]').val('');
                        $('input[name="qceratingfrom"]').val('');
                        $('input[name="qceratingto"]').val('');
                    } else {
                        toastr.error(response.message);
                        console.log(response);
                    }
                },
                error: function(xhr, status, error, message) {
                    var errorMessage = xhr.responseText ? JSON.parse(xhr.responseText).message : 'An error occurred';
                    toastr.error(errorMessage);
                }
            });
        });

        var dataTable = $('#schlyearsemesterTable').DataTable({
            "ajax": {
                "url": semesterReadRoute,
                "type": "GET",
            },
            destroy: true,
            info: true,
            responsive: true,
            lengthChange: true,
            searching: true,
            paging: true,
            "columns": [
                {data: 'qceschlyear'},
                {
                    data: 'qcesemester',
                    render: function(data, type, row) {
                        if (data == 1) {
                            return '1st Semester';
                        } else if (data == 2) {
                            return '2nd Semester';
                        } else if (data == 3) {
                            return 'Summer';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: null, // Using `null` since we are combining two columns
                    render: function(data, type, row) {
                        return row.qceratingfrom + ' - ' + row.qceratingto;
                    }
                },
                {
                    data: 'qcesemstat',
                    render: function(data, type, row) {
                        let badgeClass = '';

                        if (data == 1) {
                            badgeClass = 'badge bg-danger'; // Red for Deactivate
                            return `<span class="${badgeClass}">Deactivate</span>`;
                        } else if (data == 2) {
                            badgeClass = 'badge bg-success'; // Green for Activate
                            return `<span class="${badgeClass}">Activate</span>`;
                        } else if (data == 3) {
                            badgeClass = 'badge bg-info'; // Blue for Upcoming
                            return `<span class="${badgeClass}">Upcoming</span>`;
                        } else if (data == 4) {
                            badgeClass = 'badge bg-primary'; // Dark Blue for Current
                            return `<span class="${badgeClass}">Current</span>`;
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            var dropdown = '<div class="d-inline-block">' +
                                '<a class="btn btn-default btn-sm dropdown-toggle text-light dropdown-icon" data-bs-toggle="dropdown" style="background-color: #65ac86 !important; border-color: #65ac86 !important"></a>' +
                                '<div class="dropdown-menu">' +
                                '<a href="#" class="dropdown-item btn-semesteredit" data-id="' + row.id + '" data-schlyear="' + row.qceschlyear + '" data-semester="' + row.qcesemester + '" data-qceratingfrom="' + row.qceratingfrom + '" data-qceratingto="' + row.qceratingto + '" data-qcesemstat="' + row.qcesemstat + '">' +
                                '<i class="fas fa-pen"></i> Edit' +
                                '</a>' +
                                '<button type="button" value="' + data + '" class="dropdown-item semester-delete">' +
                                '<i class="fas fa-trash"></i> Delete' +
                                '</button>' +
                                '</div>' +
                                '</div>';
                            return dropdown;
                        } else {
                            return data;
                        }
                    },
                },
            ],
            "createdRow": function (row, data, index) {
                $(row).attr('id', 'tr-' + data.id); 
            }
        });
        $(document).on('semesterAdded', function() {
            dataTable.ajax.reload();
        });
    });

    $(document).on('click', '.btn-semesteredit', function() {
        var id = $(this).data('id');
        var schlyear = $(this).data('schlyear');
        var semester = $(this).data('semester');
        var ratingFrom = $(this).data('qceratingfrom');
        var ratingTo = $(this).data('qceratingto');
        var semstat = $(this).data('qcesemstat');

        $('#editSemesterId').val(id);
        $('#editSchlyearName').val(schlyear);
        $('#editSemesterName').val(semester);
        $('#editRatingfrom').val(ratingFrom);
        $('#editRatingto').val(ratingTo);
        $('#editSemstat').val(semstat);
        
        $('#editSemesterModal').modal('show');
    });

    $('#editSemesterForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: semesterUpdateRoute,
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $('#editSemesterModal').modal('hide');
                    $(document).trigger('semesterAdded');
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

    $(document).on('click', '.semester-delete', function(e) {
        var id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to recover this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: semesterDeleteRoute.replace(':id', id),
                    success: function(response) {
                        $("#tr-" + id).delay(1000).fadeOut();
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Successfully Deleted!',
                            icon: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        if(response.success) {
                            toastr.success(response.message);
                            console.log(response);
                        }
                    }
                });
            }
        })
    });

</script>