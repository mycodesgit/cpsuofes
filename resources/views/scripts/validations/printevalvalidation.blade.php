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
                progCod: {
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
                progCod: {
                    required: "Please Select Program Year & Section",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.col-md-2, .col-md-3').append(error);        
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