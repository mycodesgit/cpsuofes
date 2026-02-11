@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Users</h1>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pt-3">
                                <h6 class="card-title">
                                    <i class="fas fa-list"></i> List
                                </h6>
                            </div>
                            <div class="card-body">
                                <table id="userlistTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th>Campus</th>
                                            <th>No. of Reset</th>
                                            <th>Status</th>
                                            <th width="10%">Actions</th>
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

    <div class="modal fade" id="edituserModal" tabindex="-1" role="dialog" aria-labelledby="edituserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edituserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edituserForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edituserId">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="edituserfname"><span>First Name:</span></label>
                                    <input type="text" class="form-control" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" placeholder="Enter First Name" id="edituserfname" name="fname">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="editusermname"><span>Middle Name:</span></label>
                                    <input type="text" class="form-control" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" placeholder="Enter Middle Name" id="editusermname" name="mname">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="edituserlname"><span>Last Name:</span></label>
                                    <input type="text" class="form-control" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" placeholder="Enter Last Name" id="edituserlname" name="lname">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="edituserext"><span>Ext.:</span></label>
                                    <select class="form-control" name="ext" id="edituserext">
                                        <option value="">N/A</option>
                                        <option value="Jr." @if (old('ext') == "Jr.") {{ 'selected' }} @endif>Jr.</option>
                                        <option value="Sr." @if (old('ext') == "Sr.") {{ 'selected' }} @endif>Sr.</option>
                                        <option value="III" @if (old('ext') == "III") {{ 'selected' }} @endif>III</option>
                                        <option value="IV" @if (old('ext') == "IV") {{ 'selected' }} @endif>IV</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="form-group mb-3">
                                    <label for="edituseremail"><span>Email:</span></label>
                                    <input type="email" class="form-control" id="edituseremail" name="email">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="editusercamp"><span>Campus:</span></label>
                                    <select class="form-control" name="campus" id="editusercamp" required="">
                                        <option disabled selected>Select</option>
                                        <option value="MC">Main</option>
                                        <option value="VC">Victorias</option>
                                        <option value="SCC">San Carlos</option>
                                        <option value="HC">Hinigaran</option>
                                        <option value="MP">Moises Padilla</option>
                                        <option value="IC">Ilog</option>
                                        <option value="CA">Candoni</option>
                                        <option value="CC">Cauayan</option>
                                        <option value="SC">Sipalay</option>
                                        <option value="HinC">Hinobaan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="edituserdept"><span>Department:</span></label>
                                    <select class="form-control" name="dept" id="edituserdept">
                                        <option disabled selected>Select</option>
                                        <option value="CAS">College of Arts and Sciences</option>
                                        <option value="CCS">College of Computer Studies</option>
                                        <option value="COTED">College of Teacher Education</option>
                                        <option value="CCJE">College of Criminal Justice Education</option>
                                        <option value="COE">College of Engineering</option>
                                        <option value="CAF">College of Agriculture and Forestry</option>
                                        <option value="CBM">College of Business Management</option>
                                        <option value="Guidance Office">Guidance Office</option>
                                        <option value="Registrar Office">Registrar Office</option>
                                        <option value="Assessment Office">Assessment Office</option>
                                        <option value="Scholarship Office">Scholarship Office</option>
                                        <option value="Cashier Office">Cashier Office</option>
                                        <option value="Graduate School Registar">Graduate School Registar</option>
                                        <option value="MIS Office">MIS Office</option>
                                        <option value="OSSA">OSSA</option>
                                        <option value="QA">QA</option>
                                        <option value="TS">Training Services</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="edituserrole"><span>User Role:</span></label>
                                    <select class="form-control" name="role" id="edituserrole">
                                        <option disabled selected>Level</option>
                                        <option value="0">Administrator</option>
                                        <option value="1">Administer QA</option>
                                        <option value="2">Administer QA Staff</option>
                                        <option value="3">Administer Result</option>
                                        <option value="4">Administer Result Staff</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeUserPassModal" tabindex="-1" role="dialog" aria-labelledby="changeUserPassModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeUserPassModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="changeUserPassForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="changeUserPassId">
                        <div class="form-group">
                            <label for="editpasswordInput">Password</label>
                            <input type="text" class="form-control" name="password" id="editpasswordInput">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="editgeneratePassword" class="btn btn-info">
                            <i class="fas fa-key"></i> Generate Pass
                        </button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUstatusModal" tabindex="-1" role="dialog" aria-labelledby="editUstatusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUstatusModalLabel">Edit User Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUstatusForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editUstatusId">
                        <div class="form-group">
                            <label for="editUstatusName">Select User Status</label>
                            <select name="ustatus" id="editUstatusName" class="form-control">
                                <option disabled selected> --Select-- </option>
                                <option value="1">Enabled</option>
                                <option value="2">Disabled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var userReadRoute = "{{ route('getUserRead') }}";
        var userCreateRoute = "{{ route('user.create') }}";
        var userUpdateRoute = "{{ route('user.update', ['id' => ':id']) }}";
        var passuserUpdateRoute = "{{ route('passUpdate', ['id' => ':studkiosid']) }}";
        var userStatusUpdateRoute = "{{ route('userUpdateStatus', ['id' => ':studkiosid']) }}";
        var userDeleteRoute = "{{ route('user.delete', ['id' => ':id']) }}";
    </script>
@endsection
