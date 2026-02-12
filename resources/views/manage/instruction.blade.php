@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Instruction</h1>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header pt-3">
                                <h6 class="card-title">
                                    <i class="ti ti-plus"></i> Add New
                                </h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" id="addInstruction">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label>Instruction: <span class="text-danger">*</span></label>
                                                <textarea class="form-control" rows="4" name="instruction"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label>Instruction Category: <span class="text-danger">*</span></label>
                                                <select class="form-control" name="instructcat">
                                                    <option disabled selected> --Select-- </option>
                                                    <option value="1">Student</option>
                                                    <option value="2">Faculty</option>
                                                </select>
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
                                <table id="instructionTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Instruction</th>
                                            <th>Category</th>
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

    <div class="modal fade" id="editinstructionModal" tabindex="-1" role="dialog" aria-labelledby="editinstructionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="editinstructionModalLabel">Edit Instruction Name</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editinstructionForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editinstructionId">
                        <div class="col-md-12 mb-3">
                            <label for="editinstructionName">Instruction: <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="6" name="instruction" id="editinstructionName"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="editinstructionStatus">Instruction Category: <span class="text-danger">*</span></label>
                            <select name="instructcat" id="editinstructionStatus" class="form-control">
                                <option value="1">Student</option>
                                <option value="2">Faculty</option>
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
        var instructionReadRoute = "{{ route('instruction.show') }}";
        var instructionCreateRoute = "{{ route('instruction.create') }}";
        var instructionUpdateRoute = "{{ route('instruction.update', ['id' => ':id']) }}";
        var instructionDeleteRoute = "{{ route('instruction.delete', ['id' => ':id']) }}";
    </script>
@endsection
