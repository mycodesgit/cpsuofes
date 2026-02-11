<script>
    $(function () {
        $('#enrollStud').validate({
            rules: {
                campus: {
                    required: true,
                },
                schlyear: {
                    required: true,
                },
                semester: {
                    required: true,
                },
                dept: {
                    required: true,
                },
                faclty: {
                    required: true,
                },
            },
            messages: {
                campus: {
                    required: "Please Select Campus",
                },
                schlyear: {
                    required: "Please Select School Year",
                },
                semester: {
                    required: "Please Select Semester",
                },
                dept: {
                    required: "Please Select College",
                },
                faclty: {
                    required: "Please Select Faculty",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.col-md-3, .col-md-12').append(error);        
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