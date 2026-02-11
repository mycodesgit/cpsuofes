<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-left"
    };
    $(document).ready(function() {
        $('#addQuestion').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: questionCreateRoute,
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        console.log(response);
                        $(document).trigger('questionAdded');
                        $('textarea[name="questiontext"]').val('');
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

        var dataTable = $('#questTable').DataTable({
            "ajax": {
                "url": questionReadRoute,
                "type": "GET",
            },
            destroy: true,
            info: true,
            responsive: true,
            lengthChange: true,
            searching: true,
            paging: true,
            "columns": [
                {
                    data: 'catName',
                    render: function(data, type, row) {
                        return '<strong>' + data + '</strong>';
                    }
                },
                {data: 'questiontext'},
                {data: 'questcat',
                        render: function(data, type, row) {
                        switch(parseInt(data)) {
                            case 1:
                                return '<span class="badge bg-success-subtle text-success">Student</span>';
                            case 2:
                                return '<span class="badge bg-info-subtle text-info">Faculty</span>';
                            default:
                                return '<span class="badge bg-secondary-subtle text-secondary">Unknown Status</span>';
                        }
                    },
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            var dropdown = '<div class="d-inline-block">' +
                                '<a class="btn btn-default btn-sm dropdown-toggle text-light dropdown-icon" data-bs-toggle="dropdown" style="background-color: #65ac86 !important; border-color: #65ac86 !important"></a>' +
                                '<div class="dropdown-menu">' +
                                '<a href="#" class="dropdown-item btn-questedit" data-id="' + row.id + '" data-catname="' + row.catName_id + '" data-questcat="' + row.questcat + '" data-question="' + row.questiontext + '">' +
                                '<i class="fas fa-pen"></i> Edit' +
                                '</a>' +
                                '<button type="button" value="' + data + '" class="dropdown-item quest-delete">' +
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
        $(document).on('questionAdded', function() {
            dataTable.ajax.reload();
        });
    });

    $(document).on('click', '.btn-questedit', function() {
        var id = $(this).data('id');
        var categoryNameID = $(this).data('catname');
        var questcat = $(this).data('questcat');
        var questionName = $(this).data('question');

        $('#editQuestId').val(id);
        $('#editQuestcatName').val(categoryNameID);
        $('#editQuestCats').val(questcat);
        $('#editQuestName').val(questionName);
        $('#editQuestModal').modal('show');
    });

    $('#editQuestForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: questionUpdateRoute,
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $('#editQuestModal').modal('hide');
                    $(document).trigger('questionAdded');
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

    $(document).on('click', '.quest-delete', function(e) {
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
                    url: questionDeleteRoute.replace(':id', id),
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