<script>
    $(function () {
        $('#addInstruction').validate({
            rules: {
                instruction: {
                    required: true,
                },
                instructcat: {
                    required: true,
                },
            },
            messages: {
                instruction: {
                    required: "Please Enter Instruction",
                },
                instructcat: {
                    required: "Please Se;ect Instruction Category",
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
        $('#editinstructionForm').validate({
            rules: {
                instruction: {
                    required: true,
                },
                instructcat: {
                    required: true,
                },
            },
            messages: {
                instruction: {
                    required: "Please Enter Instruction",
                },
                instructcat: {
                    required: "Please Se;ect Instruction Category",
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