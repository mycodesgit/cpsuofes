@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Semester</h1>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header pt-3">
                                <h6 class="card-title">
                                    <i class="ti ti-plus"></i> Add New
                                </h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" id="addSemester">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label>School Year: <span class="text-danger">*</span></label>
                                                <input type="text" name="qceschlyear" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label>Semester: <span class="text-danger">*</span></label>
                                                <select class="form-control" name="qcesemester">
                                                    <option disabled selected> --Select-- </option>
                                                    <option value="1">1st Semester</option>
                                                    <option value="2">2nd Semester</option>
                                                    <option value="3">Summer</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Rating Period from: <span class="text-danger">*</span></label>
                                                <input type="text" name="qceratingfrom" class="form-control" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Rating Period to: <span class="text-danger">*</span></label>
                                                <input type="text" name="qceratingto" class="form-control" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-12">
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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header pt-3">
                                <h6 class="card-title">
                                    <i class="fas fa-list"></i> List
                                </h6>
                            </div>
                            <div class="card-body">
                                <table id="schlyearsemesterTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>School Year</th>
                                            <th>Semester</th>
                                            <th>Rating Period</th>
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

    <div class="modal fade" id="editSemesterModal" tabindex="-1" role="dialog" aria-labelledby="editSemesterModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="editSemesterModalLabel">Edit Semester</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editSemesterForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editSemesterId">
                        <div class="col-md-12 mb-3">
                            <label for="editSchlyearName">School Year: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editSchlyearName" name="qceschlyear">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="editSemesterName">Semester: <span class="text-danger">*</span></label>
                            <select class="form-control" name="qcesemester" id="editSemesterName">
                                <option disabled selected> --Select-- </option>
                                <option value="1">1st Semester</option>
                                <option value="2">2nd Semester</option>
                                <option value="3">Summer</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="editRatingfrom">Rating Period from: <span class="text-danger">*</span></label>
                            <input type="text" id="editRatingfrom" name="qceratingfrom" class="form-control" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="editRatingto">Rating Period to: <span class="text-danger">*</span></label>
                            <input type="text" id="editRatingto" name="qceratingto" class="form-control" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="editSemstat">Status: <span class="text-danger">*</span></label>
                            <select class="form-control" id="editSemstat" name="qcesemstat">
                                <option disabled selected> --Select-- </option>
                                <option value="1">Deactivate</option>
                                <option value="2">Activate</option>
                                <option value="3">Upcoming</option>
                                <option value="4">Current</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var semesterReadRoute = "{{ route('semester.show') }}";
        var semesterCreateRoute = "{{ route('semester.create') }}";
        var semesterUpdateRoute = "{{ route('semester.update', ['id' => ':id']) }}";
        var semesterDeleteRoute = "{{ route('semester.delete', ['id' => ':id']) }}";
    </script>
@endsection
