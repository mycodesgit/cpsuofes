@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Calendar</h1>
                <div class="card">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eventModal" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Create Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('calendar.create') }}" method="POST" id="addEvent">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label>Event:</label>
                                    <input type="text" name="eventname" id="eventTitle" placeholder="Enter Event" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label>Start Date & Time:</label>
                                    <input type="datetime-local" id="eventStartTime" name="start" placeholder="Enter Event" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label>End Date & Time:</label>
                                    <input type="datetime-local" id="eventEndTime" name="end" placeholder="Enter Event" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label>Office/Department:</label>
                                    <select name="collegeID" id="collegeID" class="form-control select2bs4">
                                        <option disabled selected> --Select-- </option>
                                        @foreach ($office as $dataoffice)
                                            <option value="{{ $dataoffice->id }}" data-color="{{ $dataoffice->color }}">{{ $dataoffice->office_name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="eventcolor" id="eventcolor" class="form-control ">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-outline-success">
                                        <i class="fas fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var eventschedReadRoute = "{{ route('calendar.fetch') }}";
        var eventschedCalendarRoute = "{{ route('calendar.show') }}";
        var eventschedCreateRoute = "{{ route('calendar.create') }}";
    </script>
@endsection