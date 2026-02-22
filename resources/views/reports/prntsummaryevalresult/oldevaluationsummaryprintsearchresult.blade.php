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
                                <div class="row">
                                    <div class="col-md-10">
                                        <ul class="nav nav-pills mb-3 bg-light p-2 rounded-2 d-inline-flex" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-one-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-one" type="button" role="tab"
                                                    aria-controls="pills-one" aria-selected="true">
                                                    Summary of Evaluation
                                                </button>
                                            </li>
                                            &nbsp;
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-two-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-two" type="button" role="tab"
                                                    aria-controls="pills-two" aria-selected="false" tabindex="-1">
                                                    Monitoring and Evaluation
                                                </button>
                                            </li>
                                            &nbsp;
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-three-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-three" type="button" role="tab"
                                                    aria-controls="pills-three" aria-selected="false" tabindex="-1">
                                                    Rating Points
                                                </button>
                                            </li>
                                            &nbsp;
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-four-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-four" type="button" role="tab"
                                                    aria-controls="pills-four" aria-selected="false" tabindex="-1">
                                                    Summary Sheets
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mt-2">
                                            <button class="btn btn-info" onclick="refreshPage()">
                                                <i class="ti ti-refresh"></i> Refresh Page
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content mt-3" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-one" role="tabpanel" aria-labelledby="pills-one-tab" tabindex="0">
                                        <div class="bg-light p-2 rounded-2">
                                            <iframe id="pdfIframe" src="{{ route('gensummaryevalPDF', ['campus' => request('campus'), 'ratingfrom' => request('ratingfrom'), 'ratingto' => request('ratingto'), 'schlyear' => request('schlyear'), 'semester' => request('semester'), 'faclty' => request('faclty')]) }}"
                                                    style="width: 100%; height: 580px;" 
                                                    frameborder="0" 
                                                    class="mt-3">
                                            </iframe>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-two" role="tabpanel" aria-labelledby="pills-two-tab" tabindex="0">
                                        <div class="bg-light p-2 rounded-2">
                                            <iframe id="pdfIframe" src="{{ route('gencommentsevalPDF', ['campus' => request('campus'), 'ratingfrom' => request('ratingfrom'), 'ratingto' => request('ratingto'), 'schlyear' => request('schlyear'), 'semester' => request('semester'), 'faclty' => request('faclty')]) }}"
                                                    style="width: 100%; height: 580px;" 
                                                    frameborder="0" 
                                                    class="mt-3">
                                            </iframe>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-three" role="tabpanel" aria-labelledby="pills-three-tab" tabindex="0">
                                        <div class="bg-light p-2 rounded-2">
                                            <iframe id="pdfIframe" src="{{ route('genpointsevalPDF', ['campus' => request('campus'), 'ratingfrom' => request('ratingfrom'), 'ratingto' => request('ratingto'), 'schlyear' => request('schlyear'), 'semester' => request('semester'), 'faclty' => request('faclty')]) }}"
                                                    style="width: 100%; height: 580px;" 
                                                    frameborder="0" 
                                                    class="mt-3">
                                            </iframe>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-four" role="tabpanel" aria-labelledby="pills-four-tab" tabindex="0">
                                        <div class="bg-light p-2 rounded-2">
                                            <iframe id="pdfIframe" src="{{ route('gensumsheetevalPDF', ['campus' => request('campus'), 'ratingfrom' => request('ratingfrom'), 'ratingto' => request('ratingto'), 'schlyear' => request('schlyear'), 'semester' => request('semester'), 'faclty' => request('faclty')]) }}"
                                                    style="width: 100%; height: 580px;" 
                                                    frameborder="0" 
                                                    class="mt-3">
                                            </iframe>
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
        function refreshPage() {
            location.reload();
        }
    </script>
@endsection
