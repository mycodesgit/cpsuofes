<script>
    $(function () {
        $('#addSemester').validate({
            rules: {
                qceschlyear: {
                    required: true,
                },
                qcesemester: {
                    required: true,
                },
                qceratingfrom: {
                    required: true,
                },
                qceratingto: {
                    required: true,
                },
            },
            messages: {
                qceschlyear: {
                    required: "Please Enter School Year",
                },
                qcesemester: {
                    required: "Please Select Semester",
                },
                qceratingfrom: {
                    required: "Please Enter Rating Period from",
                },
                qceratingto: {
                    required: "Please Enter Rating Period to",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.col-md-6, .col-md-12').append(error);        
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
        });
    });

    $(function () {
        $('#editSemesterForm').validate({
            rules: {
                qceschlyear: {
                    required: true,
                },
                qcesemester: {
                    required: true,
                },
                qceratingfrom: {
                    required: true,
                },
                qceratingto: {
                    required: true,
                },
            },
            messages: {
                qceschlyear: {
                    required: "Please Enter School Year",
                },
                qcesemester: {
                    required: "Please Select Semester",
                },
                qceratingfrom: {
                    required: "Please Enter Rating Period from",
                },
                qceratingto: {
                    required: "Please Enter Rating Period to",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.col-md-12').append(error);        
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>