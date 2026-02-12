@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Print Evaluation</h1>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pt-3">
                                <h6 class="card-title">
                                    <i class="ti ti-printer"></i> To be print
                                </h6>
                            </div>
                            <div class="card-body">
                                <iframe id="pdfIframe" src="{{ route('exportPrintSupervisorEvalPDF', ['campus' => request('campus'), 'schlyear' => request('schlyear'), 'semester' => request('semester'), 'faclty' => request('faclty')]) }}"
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
@endsection
