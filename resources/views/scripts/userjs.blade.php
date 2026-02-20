<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-left"
    };
    $(document).ready(function() {
        $('#addUser').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: userCreateRoute,
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        console.log(response);
                        $(document).trigger('userAdded');
                        $('#addUserModal').modal('hide');
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

        var dataTable = $('#userlistTable').DataTable({
            "ajax": {
                "url": userReadRoute,
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
                    data: null,
                    render: function(data, type, row) {
                        var firstname = data.fname;
                        var middleInitial = data.mname ? data.mname.substr(0, 1) + '.' : '';
                        var lastNameWithExt = data.lname;

                        // Check if ext exists and is not 'N/A' or null
                        if (data.ext && data.ext !== 'N/A' && data.ext !== null) {
                            lastNameWithExt += ' ' + data.ext;
                        }

                        return firstname + ' ' + middleInitial + ' ' + lastNameWithExt;
                    }
                },
                {
                    data: 'role',
                    render: function(data, type, row) {
                        if (data == 0) {
                            return '<span class="badge bg-info-subtle text-info">Administrator</span>';
                        } else if (data == 1) {
                            return '<span class="badge bg-success-subtle text-success" style="color: #2b2b2b">Administer QA</span>';
                        } else if (data == 2) {
                            return '<span class="badge bg-success-subtle text-success" style="color: #eee">Administer QA Staff</span>';
                        } else if (data == 3) {
                            return '<span class="badge bg-warning-subtle text-warning" style="color: #222">Administer Result</span>';
                        } else if (data == 4) {
                            return '<span class="badge bg-warning-subtle text-warning" style="color: #222">Administer Result Staff</span>';
                        } else {
                            return data;
                        }
                    }
                },
                {data: 'email'},
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
                {data: 'resetcount'},
                {data: 'ustatus',
                        render: function(data, type, row) {
                        switch(parseInt(data)) {
                            case 1:
                                return '<span class="badge bg-success-subtle text-success">Enabled</span>';
                            case 2:
                                return '<span class="badge bg-danger-subtle text-danger">Disabled</span>';
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
                                '<a class="btn btn-success btn-sm dropdown-toggle text-light dropdown-icon" data-bs-toggle="dropdown"></a>' +
                                '<div class="dropdown-menu">' +
                                '<a href="#" class="dropdown-item btn-useredit" data-id="' + row.id + '" data-fname="' + row.fname + '" data-mname="' + row.mname + '" data-lname="' + row.lname + '" data-ext="' + row.ext + '" data-email="' + row.email + '" data-campus="' + row.campus + '" data-dept="' + row.dept + '" data-role="' + row.role + '">' +
                                '<i class="fas fa-pen"></i> Edit' +
                                '</a>' +
                                '<a href="#" class="dropdown-item btn-changepass" data-id="' + row.id + '">' +
                                '<i class="fas fa-lock"></i> Change Pass' +
                                '</a>' +
                                '<a href="#" class="dropdown-item btn-ustatusedit" data-id="' + row.id + '" data-ustatus="' + row.ustatus + '">' +
                                '<i class="fas fa-toggle-on"></i> Status' +
                                '</a>' +
                                '<button type="button" value="' + data + '" class="dropdown-item user-delete">' +
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
        $(document).on('userAdded', function() {
            dataTable.ajax.reload();
        });
    });

    $(document).on('click', '.btn-useredit', function() {
        var id = $(this).data('id');
        var fname = $(this).data('fname');
        var mname = $(this).data('mname');
        var lname = $(this).data('lname');
        var ext = $(this).data('ext');
        var email = $(this).data('email');
        var campus = $(this).data('campus');
        var dept = $(this).data('dept');
        var role = $(this).data('role');

        $('#edituserId').val(id);
        $('#edituserfname').val(fname);
        $('#editusermname').val(mname);
        $('#edituserlname').val(lname);
        $('#edituserext').val(ext);
        $('#edituseremail').val(email);
        $('#editusercamp').val(campus);
        $('#edituserdept').val(dept);
        $('#edituserrole').val(role);
        
        $('#edituserModal').modal('show');
    });

    $('#edituserForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: userUpdateRoute,
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $('#edituserModal').modal('hide');
                    $(document).trigger('userAdded');
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

    $(document).on('click', '.btn-changepass', function() {
        var id = $(this).data('id');

        $('#changeUserPassId').val(id);

        $('#changeUserPassModal').modal('show');
    });

    $('#changeUserPassForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: passuserUpdateRoute,
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $('#changeUserPassModal').modal('hide');
                    $(document).trigger('userAdded');
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

    $(document).on('click', '.btn-ustatusedit', function() {
        var id = $(this).data('id');
        var ustatus = $(this).data('ustatus');

        $('#editUstatusId').val(id);
        $('#editUstatusName').val(ustatus);

        $('#editUstatusModal').modal('show');
    });

    $('#editUstatusForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: userStatusUpdateRoute,
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $('#editUstatusModal').modal('hide');
                    $(document).trigger('userAdded');
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

    $(document).on('click', '.user-delete', function(e) {
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
                    url: userDeleteRoute.replace(':id', id),
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


    $(document).ready(function() {
        function editgeneratePassword() {
            var length = Math.floor(Math.random() * 2) + 8; // Generates either 8 or 9
            var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$&*";
            var password = "";
            for (var i = 0; i < length; i++) {
                var randomIndex = Math.floor(Math.random() * charset.length);
                password += charset[randomIndex];
            }
            return password;
        }

        $('#editgeneratePassword').click(function() {
            var editgeneratedPassword = editgeneratePassword();
            $('#editpasswordInput').val(editgeneratedPassword); 
        });
    });
</script>