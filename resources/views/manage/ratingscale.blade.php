@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Rating Scale</h1>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header pt-3">
                                <h6 class="card-title">
                                    <i class="ti ti-plus"></i> Add New
                                </h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" id="addRatingscale">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label>Scale: <span class="text-danger">*</span></label>
                                                <input type="number" name="inst_scale" class="form-control form-control-sm" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label>Descriptive Rating: <span class="text-danger">*</span></label>
                                                <input type="text" name="inst_descRating" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label>Qualitative Description: <span class="text-danger">*</span></label>
                                                <textarea class="form-control" rows="4" name="inst_qualDescription"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label>Status: <span class="text-danger">*</span></label>
                                                <select class="form-control form-control-sm" name="instratingscalestat">
                                                    <option disabled selected> --Select-- </option>
                                                    <option value="1">Active</option>
                                                    <option value="2">Unactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-outline-success tbn-md">
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
                                <table id="ratingscaleTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Scale</th>
                                            <th>Descriptive Rating</th>
                                            <th>Qualitative Description</th>
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

    <div class="modal fade" id="editInstModal" tabindex="-1" role="dialog" aria-labelledby="editInstModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="editInstModalLabel">Edit Rating Scale</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editRatingscaleForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editInstId">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="editInstscale">Scale:</label>
                                <input type="number" id="editInstscale" name="inst_scale" class="form-control" autofocus>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="editInstdescrating">Descriptive Rating:</label>
                                <input type="text" id="editInstdescrating" name="inst_descRating" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="editInstqualdesc">Descriptive Rating:</label>
                                <textarea class="form-control" rows="4" id="editInstqualdesc" name="inst_qualDescription"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="editInstqualdesc">Status:</label>
                                <select class="form-control form-control-sm" name="instratingscalestat" id="editInststat">
                                    <option disabled selected> --Select-- </option>
                                    <option value="1">Active</option>
                                    <option value="2">Unactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var ratingscaleReadRoute = "{{ route('ratingscale.show') }}";
        var ratingscaleCreateRoute = "{{ route('ratingscale.create') }}";
        var ratingscaleUpdateRoute = "{{ route('ratingscale.update', ['id' => ':id']) }}";
        var ratingscaleDeleteRoute = "{{ route('ratingscale.delete', ['id' => ':id']) }}";
    </script>
@endsection
