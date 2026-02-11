<script>
    $(function () {
        $('#addCategory').validate({
            rules: {
                catName: {
                    required: true,
                },
            },
            messages: {
                catName: {
                    required: "Please Enter Category",
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

    $(function () {
        $('#editCatForm').validate({
            rules: {
                catName: {
                    required: true,
                },
            },
            messages: {
                catName: {
                    required: "Please Enter Category",
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