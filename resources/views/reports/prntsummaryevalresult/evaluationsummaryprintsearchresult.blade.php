@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Evaluation Result</h1>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pt-3">
                                <h6 class="card-title">
                                    <i class="ti ti-search"></i> Summary of Evaluation Result
                                </h6>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3 bg-light p-2 rounded-2 d-inline-flex" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-summaryevaluation-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-summaryevaluation" type="button" role="tab"
                                            aria-controls="pills-summaryevaluation" aria-selected="true">
                                            Summary of Evaluation
                                        </button>
                                    </li>
                                    &nbsp;
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-monitoringevaluation-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-monitoringevaluation" type="button" role="tab"
                                            aria-controls="pills-monitoringevaluation" aria-selected="false" tabindex="-1">
                                            Monitoring and Evaluation
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-summaryevaluation" role="tabpanel" aria-labelledby="pills-summaryevaluation-tab" tabindex="0">
                                        <div class="bg-light p-2 rounded-2">
                                            <iframe id="pdfIframe" src="{{ route('individualresultEvalPDF', ['campus' => request('campus'), 'ratingfrom' => request('ratingfrom'), 'ratingto' => request('ratingto'), 'schlyear' => request('schlyear'), 'semester' => request('semester'), 'faclty' => request('faclty')]) }}"
                                                    style="width: 100%; height: 580px;" 
                                                    frameborder="0" 
                                                    class="mt-3">
                                            </iframe>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-monitoringevaluation" role="tabpanel" aria-labelledby="pills-monitoringevaluation-tab" tabindex="0">
                                        <div class="bg-light p-2 rounded-2">
                                            s
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var getfacltyReadRoute = "{{ route('getFacultycamp') }}";
    </script>
@endsection
