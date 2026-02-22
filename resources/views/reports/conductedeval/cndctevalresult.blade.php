@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Conducted Faculty Evaluation</h1>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pt-3">
                                <h6 class="card-title">
                                    <i class="ti ti-search"></i> Conducted Faculty Evaluation
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
                                                    Conducted Faculty Evaluation
                                                </button>
                                            </li>
                                            &nbsp;
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-two-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-two" type="button" role="tab"
                                                    aria-controls="pills-two" aria-selected="false" tabindex="-1">
                                                    Conducted Faculty Evaluation PDF
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
                                            <table id="cfe" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>College</th>
                                                        <th>Subject Name</th>
                                                        <th>Faculty</th>
                                                        <th>Subject Section</th>
                                                        <th>No. of Stud</th>
                                                        <th>No. of Stud Eval</th>
                                                        <th>% Eval</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalSublecredit = 0;
                                                        $totalSublabcredit = 0;
                                                        $totalSubUnit = 0;
                                                        $totalStudentCount = 0;
                                                        $totalStudentEvalCount = 0;
                                                        $totalStudentEvalPercentCount = 0;
                                                        $totalOverAllEvalPercentCount = 0;
                                                    @endphp
                                                    @foreach($facloadsched as $datafacloadsched)
                                                        @if(isset($evalCounts[$datafacloadsched->subject_id]))
                                                            @php
                                                                $totalSublecredit += $datafacloadsched->sublecredit;
                                                                $totalSublabcredit += $datafacloadsched->sublabcredit;
                                                                $totalSubUnit += $datafacloadsched->sub_unit;
                                                                $totalStudentCount += $datafacloadsched->studentCount;
                                                                $totalStudentEvalCount += $evalCounts[$datafacloadsched->subject_id]->eval_count;
                                                                $totalStudentEvalPercentCount = $evalCounts[$datafacloadsched->subject_id]->eval_count / $datafacloadsched->studentCount * 100;
                                                                $totalOverAllEvalPercentCount = $totalStudentEvalCount / $totalStudentCount * 100;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $datafacloadsched->dept }}</td>
                                                                <td>{{ $datafacloadsched->sub_name }} - {{ $datafacloadsched->sub_title }}</td>
                                                                <td>{{ $datafacloadsched->lname }}, {{ $datafacloadsched->fname }} {{ substr($datafacloadsched->mname, 0, 2) }}</td>
                                                                <td>{{ $datafacloadsched->subSec }}</td>
                                                                <td>{{ $datafacloadsched->studentCount }}</td>
                                                                <td>{{ $evalCounts[$datafacloadsched->subject_id]->eval_count ?? 0 }}</td>
                                                                <td>{{ number_format($totalStudentEvalPercentCount, 2) }} %</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                                <tr>
                                                    <td style="text-align: right; border: none;" colspan="4"><strong>TOTAL:</strong></td>
                                                    <td style="text-align: center; border: none;" width="10%"><strong>{{ $totalStudentCount }}</strong></td>
                                                    <td style="text-align: center; border: none;" width="10%"><strong>{{ $totalStudentEvalCount }}</strong></td>
                                                    <td style="text-align: center; border: none;" width="10%"><strong>{{ number_format($totalOverAllEvalPercentCount, 2) }} %</strong></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-two" role="tabpanel" aria-labelledby="pills-two-tab" tabindex="0">
                                        <div class="bg-light p-2 rounded-2">
                                            <iframe id="pdfIframe" src="{{ route('facultySearchFilterPDF', ['campus' => request('campus'), 'ratingfrom' => request('ratingfrom'), 'ratingto' => request('ratingto'), 'schlyear' => request('schlyear'), 'semester' => request('semester'), 'faclty' => request('faclty')]) }}"
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
    </script>

    <script>
        document.getElementById('schlyear').addEventListener('change', function() {
            let selected = this.options[this.selectedIndex];
            document.getElementById('ratingfrom').value = selected.getAttribute('data-from');
            document.getElementById('ratingto').value = selected.getAttribute('data-to');
        });

        // Run once on page load for the default selected value
        document.getElementById('schlyear').dispatchEvent(new Event('change'));
    </script>

    <script>
        var getfacltyReadRoute = "{{ route('getFacultycamp') }}";
        function refreshPage() {
            location.reload();
        }
    </script>
@endsection
