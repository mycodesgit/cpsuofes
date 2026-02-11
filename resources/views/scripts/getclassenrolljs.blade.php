<script>
    $(document).ready(function() {
        $('#schlyear, #semester, #campus').change(function() {
            var schlyear = $('#schlyear').val();
            var semester = $('#semester').val();
            var campus = $('#campus').val();
            if (schlyear && semester) {
                $.ajax({
                    url: classenrollyrsecReadRoute,
                    type: 'GET',
                    data: {
                        schlyear: schlyear,
                        semester: semester,
                        campus: campus
                    },
                    success: function(data) {
                        $('#progCod').empty();
                        $('#progCod').append('<option disabled selected>Select a course</option>');
                        $.each(data, function(key, value) {
                            $('#progCod').append('<option value="' + value.progCode + ' ' + value.classSection + '">' + value.progAcronym + ' ' + value.classSection + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>