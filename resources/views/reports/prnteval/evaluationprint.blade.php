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
                                            Student Evaluation of Teachers
                                        </button>
                                    </li>
                                    &nbsp;
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-supeval-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-supeval" type="button" role="tab"
                                            aria-controls="pills-supeval" aria-selected="false" tabindex="-1">
                                            Supervisor'S Evaluation of Faculty
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-studeval" role="tabpanel" aria-labelledby="pills-studeval-tab" tabindex="0">
                                        <div class="bg-light p-2 rounded-2">
                                            <form method="GET" action="{{ route('subprint_searchresultStore') }}" id="enrollStud">
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
                                                            @foreach($currsem as $datacurrsem)
                                                                <option value="{{ $datacurrsem->qceschlyear }}">{{ $datacurrsem->qceschlyear }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mt-2">
                                                        <label class="mb-1">Semester <span class="text-danger">*</span></label>
                                                        <select class="form-control form-control-sm" name="semester" id="semester">
                                                            <option disabled selected> --Select-- </option>
                                                            <option value="1" @if (old('type') == 1) {{ 'selected' }} @endif>First Semester</option>
                                                            <option value="2" @if (old('type') == 2) {{ 'selected' }} @endif>Second Semester</option>
                                                            <option value="3" @if (old('type') == 3) {{ 'selected' }} @endif>Summer</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mt-2">
                                                        <label class="mb-1">Course <span class="text-danger">*</span></label>
                                                        <select class="form-control form-control-sm select2bs4" name="progCod" id="progCod">
                                                            <option disabled selected> --Select a course-- </option>
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
                                            <form method="GET" action="#" id="enrollStud">
                                                @csrf

                                                <div class="row container">
                                                    <div class="col-md-2 mt-2">
                                                        <label class="mb-1">Campus <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="campus" id="campus">
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
                                                        <select class="form-control" name="schlyear" id="schlyear">
                                                            @foreach($currsem as $datacurrsem)
                                                                <option value="{{ $datacurrsem->qceschlyear }}">{{ $datacurrsem->qceschlyear }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mt-2">
                                                        <label class="mb-1">Semester <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="semester" id="semester">
                                                            <option disabled selected>Select</option>
                                                            <option value="1" @if (old('type') == 1) {{ 'selected' }} @endif>First Semester</option>
                                                            <option value="2" @if (old('type') == 2) {{ 'selected' }} @endif>Second Semester</option>
                                                            <option value="3" @if (old('type') == 3) {{ 'selected' }} @endif>Summer</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mt-2">
                                                        <label class="mb-1">Course <span class="text-danger">*</span></label>
                                                        <select class="form-control select2bs4" name="progCod" id="progCod">
                                                            <option disabled selected>Select a course</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2 mt-2">
                                                        <label class="mb-1">&nbsp;</label>
                                                        <button type="submit" class="form-control btn btn-success btn-md">OK</button>
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
@endsection
