<script>
    $(function () {
        $('#addRatingscale').validate({
            rules: {
                inst_scale: {
                    required: true,
                },
                inst_descRating: {
                    required: true,
                },
                inst_qualDescription: {
                    required: true,
                },
            },
            messages: {
                inst_scale: {
                    required: "Please Enter Scale",
                },
                inst_descRating: {
                    required: "Please Enter Descriptive Rating",
                },
                inst_qualDescription: {
                    required: "Please Enter Description",
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