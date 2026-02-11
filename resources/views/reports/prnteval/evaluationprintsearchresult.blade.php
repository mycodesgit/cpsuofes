@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Print Evaluation</h1>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header pt-3">
                                <h6 class="card-title">
                                    <i class="ti ti-printer"></i> To be print
                                </h6>
                            </div>
                            <div class="card-body">
                                <table id="submitevalTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Faculty</th>
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
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header pt-3">
                                <h6 class="card-title">
                                    <i class="ti ti-printer"></i> Done print
                                </h6>
                            </div>
                            <div class="card-body">
                                <table id="doneprintTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Faculty</th>
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

    <div class="modal fade" id="viewEvalRatePDFModal" role="dialog" aria-labelledby="viewEvalRatePDFModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewEvalRatePDFModalLabel">Print PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframe" src="" style="width: 100%; height: 500px;" frameborder="0" class="mt-3"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form id="editInstForm">
                        <input type="text" name="id" id="viewEvalRatePDFId" hidden>
                        <button type="submit" class="btn btn-success" id="btnDonePrint">Done Print</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var submissionReadRoute = "{{ route('getevalsubratelistRead') }}";
        var doneprintReadRoute = "{{ route('getevalsubrateprintedlistRead') }}";
        var studentevalsubPDFReadRoute = "{{ route('exportPrintEvalPDF') }}";
        var studentevalsubPDFprintUpdateReadRoute = "{{ route('updateStatprint') }}";
        var classenrollyrsecReadRoute = "{{ route('getCoursesyearsec') }}";
    </script>
@endsection
