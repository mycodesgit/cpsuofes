@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Category</h1>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header pt-3">
                                <h6 class="card-title">
                                    <i class="ti ti-plus"></i> Add New
                                </h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" id="addCategory">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label>Category Name: <span class="text-danger">*</span></label>
                                                <input type="text" name="catName" class="form-control">
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
                                <table id="categoryTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
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

    <div class="modal fade" id="editCatModal" tabindex="-1" role="dialog" aria-labelledby="editCatModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="editCatModalLabel">Edit Category Name</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCatForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editCatId">
                        <div class="col-md-12 mb-3">
                            <label for="editCatName">Category Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editCatName" name="catName">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="editCatName">Category Status: <span class="text-danger">*</span></label>
                            <select name="catstatus" id="editCatStatus" class="form-control">
                                <option value="1">Not Active</option>
                                <option value="2">Active</option>
                                <option value="3">Upcoming</option>
                            </select>
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
        var categoryReadRoute = "{{ route('category.show') }}";
        var categoryCreateRoute = "{{ route('category.create') }}";
        var categoryUpdateRoute = "{{ route('category.update', ['id' => ':id']) }}";
        var categoryDeleteRoute = "{{ route('category.delete', ['id' => ':id']) }}";
    </script>
@endsection
