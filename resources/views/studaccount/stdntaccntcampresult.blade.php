@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Student Accounts</h1>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pt-3">
                                <h5 class="card-title">
                                    <i class="fas fa-list"></i> List
                                </h5>
                            </div>
                            <div class="card-body">
                                <button type="button" class="btn btn-success btn-sm mb-4" data-bs-toggle="modal" data-target="#modal-kioskuser">
                                    <i class="fas fa-user-plus"></i> Add New
                                </button>
                                <table id="kioskuser" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Student ID No.</th>
                                            <th>Lastname</th>
                                            <th>Firstname</th>
                                            <th>Middle Initial</th>
                                            <th>No. of Reset</th>
                                            <th>Campus</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editKioskUserModal" tabindex="-1" role="dialog" aria-labelledby="editKioskUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKioskUserModalLabel">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editKioskUserForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editKioskUserId">
                        <div class="form-group mb-3">
                            <label for="editKioskStudID">Student ID Number</label>
                            <input type="text" class="form-control" id="editKioskStudID" name="studid" oninput="formatInput(this); this.value = this.value.toUpperCase()" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="editpasswordInput">Password</label>
                            <input type="text" class="form-control" name="password" id="editpasswordInput" oninput="this.value = this.value.toUpperCase()">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="editgeneratePassword" class="btn btn-success">
                            <i class="fas fa-key"></i> Generate Pass
                        </button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function formatInput(input) {
            let cleaned = input.value.replace(/[^A-Za-z0-9]/g, '');
            
            if (cleaned.length > 0) {
                let formatted = cleaned.substring(0, 4) + '-' + cleaned.substring(4, 8) + '-' + cleaned.substring(8, 9);
                input.value = formatted;
            } else {
                input.value = '';
            }
        }

        function handleDelete(event) {
            if (event.key === 'Backspace') {
                let input = event.target;
                let value = input.value;
                input.value = value.substring(0, value.length - 1);
                formatInput(input);
            }
        }

        function fetchStudentName(studid) {
            const urlParams = new URLSearchParams(window.location.search);
            const encryptedCampus = urlParams.get('campus');

            if (studid && encryptedCampus) {
                const url = `{{ route('getStudentById', ['id' => ':id']) }}`.replace(':id', studid) + `?campus=${encryptedCampus}`;
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            document.getElementById('studentName').value = 'Student not found';
                        } else {
                            const fullName = `${data.lname}, ${data.fname} ${data.mname}`;
                            document.getElementById('studentName').value = fullName.toUpperCase();
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching student:', error);
                        document.getElementById('studentName').value = 'Error fetching student';
                    });
            } else {
                document.getElementById('studentName').value = '';
            }
        }

    </script>

    <script>
        var kioskuserReadRoute = "{{ route('adminkiosk.show') }}";
        var kioskuserCreateRoute = "{{ route('adminkiosk.create') }}";
        var kioskuserUpdateRoute = "{{ route('adminkiosk.update', ['id' => ':studkiosid']) }}";
    </script>
@endsection
