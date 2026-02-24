@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Print Evaluation</h1>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3 bg-light p-2 rounded-2 d-inline-flex" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-studeval-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-studeval" type="button" role="tab"
                                            aria-controls="pills-studeval" aria-selected="true">
                                            ANNEX A - SET Rating
                                        </button>
                                    </li>
                                    &nbsp;
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-supeval-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-supeval" type="button" role="tab"
                                            aria-controls="pills-supeval" aria-selected="false" tabindex="-1">
                                            ANNEX B - SEF Rating
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-studeval" role="tabpanel" aria-labelledby="pills-studeval-tab" tabindex="0">
                                        <div class="bg-light p-2 rounded-2">
                                            <form method="GET" action="{{ route('subprintstudent_searchresultStore') }}" id="enrollStud">
                                                @csrf

                                                <div class="row container">
                                                    <div class="col-md-2 mt-2">
                                                        <label class="mb-1">Campus <span class="text-danger">*</span></label>
                                                        <select class="form-control form-control-sm" name="campus" id="campus">
                                                            <option disabled selected> --Select-- </option>
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

                                                    <div class="col-md-2 mt-2">
                                                        <label class="mb-1">School Year <span class="text-danger">*</span></label>
                                                        <select class="form-control form-control-sm" name="schlyear" id="schlyear">
                                                            <option disabled selected> --Select-- </option>
                                                            @foreach($currsem as $datacurrsem)
                                                                <option value="{{ $datacurrsem->qceschlyear }}">{{ $datacurrsem->qceschlyear }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mt-2">
                                                        <label class="mb-1">Semester <span class="text-danger">*</span></label>
                                                        <select class="form-control form-control-sm" name="semester" id="semester">
                                                            <option disabled selected> --Select-- </option>
                                                            <option value="1" id="sem1">First Semester</option>
                                                            <option value="2" id="sem2">Second Semester</option>
                                                            <option value="3" id="sem3">Summer</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mt-2">
                                                        <label class="mb-1">Course <span class="text-danger">*</span></label>
                                                        <select class="form-control form-control-sm select2" name="progCod" id="progCod">
                                                            <option disabled selected> --Select-- </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2 mt-2">
                                                        <label class="mb-1">&nbsp;</label>
                                                        <button type="submit" class="form-control form-control-sm btn btn-success btn-sm">OK</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-supeval" role="tabpanel" aria-labelledby="pills-supeval-tab" tabindex="0">
                                        <div class="bg-light p-2 rounded-2">
                                            <form method="GET" action="{{ route('subprintsupervisor_searchresultStore') }}" id="enrollStud">
                                                @csrf

                                                    <div class="row">
                                                        <div class="col-md-3 mb-3">
                                                            <label>Campus<span class="text-danger">*</span></label>
                                                            <select class="form-control form-control-sm" name="campus" id="campusprint">
                                                                <option disabled selected> --Select-- </option>
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
                                                                <option value="VE">Valladolid</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <label>School Year<span class="text-danger">*</span></label>
                                                            <select class="form-control form-control-sm" name="schlyear" id="schlyearprint">
                                                                <option disabled selected> --Select-- </option>
                                                                @foreach($currsemfac as $datacurrsemfac)
                                                                    <option 
                                                                        value="{{ $datacurrsemfac->qceschlyear }}"
                                                                        data-from="{{ $datacurrsemfac->qceratingfrom }}"
                                                                        data-to="{{ $datacurrsemfac->qceratingto }}"
                                                                    >
                                                                        {{ $datacurrsemfac->qceschlyear }} ({{ $datacurrsemfac->qceratingfrom }} - {{ $datacurrsemfac->qceratingto }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="ratingfrom" id="ratingfrom">
                                                            <input type="hidden" name="ratingto" id="ratingto">
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <label>Semester<span class="text-danger">*</span></label>
                                                            <select class="form-control form-control-sm" name="semester" id="semesterprint">
                                                                <option disabled selected> --Select-- </option>
                                                                <option value="1">First Semester</option>
                                                                <option value="2">Second Semester</option>
                                                                <option value="3">Summer</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <label>College<span class="text-danger">*</span></label>
                                                            <select class="form-control form-control-sm" name="dept" id="dept">
                                                                <option disabled selected> ---Select---</option>
                                                                @foreach($collegelist as $datacollegelist)
                                                                    <option value="{{ $datacollegelist->college_abbr }}">{{ $datacollegelist->college_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-12 mb-3">
                                                            <label>Faculty<span class="text-danger">*</span></label>
                                                            <select class="form-control form-control-sm select2" name="faclty" id="faclty">
                                                                <option disabled selected> --Select-- </option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label>&nbsp;</label>
                                                            <button type="submit" class="form-control form-control-sm btn btn-success btn-sm">Search</button>
                                                        </div>
                                                    </div>
                                            </form>
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
        var classenrollyrsecReadRoute = "{{ route('getCoursesyearsec') }}";
    </script>

    <script>
        var getfacltyReadRoute = "{{ route('getFacultycamp') }}";
    </script>

    <script>
        const schoolYear = document.getElementById('schlyear');
        const sem1 = document.getElementById('sem1');
        const semester = document.getElementById('semester');

        schoolYear.addEventListener('change', function () {

            semester.selectedIndex = 0;

            if (this.value === '2025-2026') {
                sem1.disabled = true;
                sem1.style.display = 'none';
            } else {
                sem1.disabled = false;
                sem1.style.display = 'block';
            }
        });
    </script>
@endsection
