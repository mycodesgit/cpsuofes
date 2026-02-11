<script>
    $(document).ready(function () {
        function fetchFaculty() {
            var campus = $('#campus').val();
            var dept = $('#dept').val();

            if (campus && dept) {
                $.ajax({
                    url: getfacltyReadRoute,
                    type: 'GET',
                    data: {
                        campus: campus,
                        dept: dept
                    },
                    success: function (data) {
                        $('#faclty').empty();
                        $('#faclty').append('<option disabled selected>Select a Faculty</option>');
                        $.each(data, function (key, value) {
                            $('#faclty').append('<option value="' + value.fctyid + '">' + value.lname + ', ' + value.fname + '</option>');
                        });
                    }
                });
            }
        }

        $('#campus, #dept').change(function () {
            fetchFaculty();
        });
    });


    // $(document).ready(function () {
    //     $('#schlyear, #semester').change(function () {
    //         var schlyear = $('#schlyear').val();
    //         var semester = $('#semester').val();

    //         if (schlyear && semester) {
    //             $.ajax({
    //                 url: getfacltyReadRoute,
    //                 type: 'GET',
    //                 success: function (data) {
    //                     $('#faclty').empty();
    //                     $('#faclty').append('<option disabled selected>Select a Faculty</option>');
    //                     $.each(data, function (key, value) {
    //                         $('#faclty').append('<option value="' + value.fctyid + '">' + value.lname + ', ' + value.fname + '</option>');
    //                     });
    //                 }
    //             });
    //         }
    //     });

    //     $('#schlyear, #semester').trigger('change');
    // });

    $(document).ready(function () {
        $('#schlyeardean, #semesterdean').change(function () {
            var schlyear = $('#schlyeardean').val();
            var semester = $('#semesterdean').val();

            if (schlyear && semester) {
                $.ajax({
                    url: getfacltyReadRoute, 
                    type: 'GET',
                    data: {
                        schlyear: schlyear,
                        semester: semester
                    },
                    success: function (data) {
                        $('#faclty').empty();
                        $('#faclty').append('<option disabled selected>Select a Faculty</option>');
                        $.each(data, function (key, value) {
                            $('#faclty').append('<option value="' + value.fctyid + '">' + value.lname + ', ' + value.fname + '</option>');
                        });
                    }
                });
            }
        });

        $('#schlyeardean, #semesterdean').trigger('change'); // auto load on page ready
    });
</script>