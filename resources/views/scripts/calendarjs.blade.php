<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right"
    };
    $(document).ready(function() {
        $('#addEvent').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: eventschedCreateRoute,
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        console.log(response);
                        $(document).trigger('eventAdded');
                        $('input[name="eventname"]').val('');
                        $('input[name="eventStartTime"]').val('');
                        $('input[name="eventEndTime"]').val('');
                        $('select[name="collegeID"]').val('');
                        $('#eventModal').modal('hide');
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

        var dataTable = $('#schedeventTable').DataTable({
            "ajax": {
                "url": eventschedReadRoute,
                "type": "GET",
            },
            destroy: true,
            info: false,
            responsive: true,
            lengthChange: false,
            searching: false,
            paging: true,
            "order": [[1, "asc"]],
            "columns": [
                {data: 'eventname'},
                {data: 'office_abbr'},
                {
                    data: 'id',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            var dropdown = '<div class="d-inline-block">' +
                                '<a class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"></a>' +
                                '<div class="dropdown-menu">' +
                                '<a href="#" class="dropdown-item btn-eventedit" data-id="' + row.id + '" data-event="' + row.eventname + '" data-start="' + row.start + '" data-end="' + row.end + '" data-office="' + row.officeID + '">' +
                                '<i class="fas fa-pen"></i> Edit' +
                                '</a>' +
                                '<button type="button" value="' + data + '" class="dropdown-item event-delete">' +
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

        $(document).on('eventAdded', function() {
            dataTable.ajax.reload();
        });
    });

    $(document).ready(function() {
        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDay) {
                var defaultStartTime = moment('08:00:00', 'HH:mm:ss');
                var defaultEndTime = moment('17:00:00', 'HH:mm:ss');
                
                start.set({
                    'hour': defaultStartTime.hour(),
                    'minute': defaultStartTime.minute(),
                    'second': defaultStartTime.second()
                });
                
                end.set({
                    'hour': defaultEndTime.hour(),
                    'minute': defaultEndTime.minute(),
                    'second': defaultEndTime.second()
                });
                
                var adjustedEndDate = moment(end).subtract(1, 'day');
                
                $('#eventTitle').val('Faculty Evaluation');
                $('#eventStartTime').val(start.format('YYYY-MM-DD HH:mm:ss'));
                $('#eventEndTime').val(adjustedEndDate.format('YYYY-MM-DD HH:mm:ss'));
                $('#eventModal').modal('show');
            },
            events: function(start, end, timezone, callback) {
                $.ajax({
                    url: eventschedCalendarRoute,
                    method: 'GET',
                    dataType: 'json',
                    success: function(events) {
                        callback(events);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching events: " + error);
                    }
                });
            },
            themeSystem: 'bootstrap',
            selectable: true,
            selectHelper: true,
            navLinks: true,
            displayEventTime: true,
            editable: true,
            height: 800,
            contentHeight: 880,
            expandRows: false,
            eventClick: function(calEvent, jsEvent, view) {
                var startTime = calEvent.start.format('h:mm A');
                var endTime = calEvent.end.format('h:mm A');
                
                Swal.fire({
                    title: calEvent.title,
                    html: `
                        Start from: ${moment(calEvent.start).format("MMM. D, YYYY, h:mm a")}<br>
                        Ends on: ${moment(calEvent.end).format("MMM. D, YYYY, h:mm a")}`,
                    icon: "success",
                    confirmButtonText: "OK",
                });
            },
        });

        
        setInterval(function() {
            calendar.fullCalendar('refetchEvents');
        }, 5000);
    });
</script>