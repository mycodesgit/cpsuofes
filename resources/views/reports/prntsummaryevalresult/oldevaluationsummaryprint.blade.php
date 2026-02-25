@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Old Evaluation Result</h1>
                <div class="row">

                    @if(in_array(Auth::guard('web')->user()->role, [0,1,3,4]))
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-header pt-3">
                                    <h6 class="card-title">
                                        <i class="ti ti-search"></i> Search Faculty Evaluation and Development Acknowledgement Form
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="{{ route('summaryEvalFilter') }}" id="enrollStud">
                                        @csrf
                                        
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label>Campus<span class="text-danger">*</span></label>
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
                                                        <option value="VE">Valladolid</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label>School Year<span class="text-danger">*</span></label>
                                                    <select class="form-control form-control-sm" name="schlyear" id="schlyear">
                                                        @foreach($currsem as $datacurrsem)
                                                            <option 
                                                                value="{{ $datacurrsem->qceschlyear }}"
                                                                data-from="{{ $datacurrsem->qceratingfrom }}"
                                                                data-to="{{ $datacurrsem->qceratingto }}"
                                                            >
                                                                {{ $datacurrsem->qceschlyear }} ({{ $datacurrsem->qceratingfrom }} - {{ $datacurrsem->qceratingto }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="ratingfrom" id="ratingfrom">
                                                    <input type="hidden" name="ratingto" id="ratingto">
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label>Semester<span class="text-danger">*</span></label>
                                                    <select class="form-control form-control-sm" name="semester" id="semester">
                                                        <option disabled selected>Select</option>
                                                        <option value="1" @if (old('type') == 1) {{ 'selected' }} @endif>First Semester</option>
                                                        <option value="2" @if (old('type') == 2) {{ 'selected' }} @endif>Second Semester</option>
                                                        <option value="3" @if (old('type') == 3) {{ 'selected' }} @endif>Summer</option>
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
                                                    <select class="form-control form-control-sm select2bs4" name="faclty" id="faclty">
                                                        <option disabled selected> --Select--</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <label>&nbsp;</label>
                                                    <button type="submit" class="form-control form-control-sm btn btn-success btn-sm">Search</button>
                                                </div>
                                            </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if(in_array(Auth::guard('web')->user()->role, [0,1,3,4]))
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header pt-3">
                                    <h6 class="card-title">
                                        <i class="ti ti-search"></i> Search Student Evaluation for Teacher
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="{{ route('subprint_searchresultStore') }}" id="enrollStud">
                                        @csrf

                                        <div class="row container">
                                            <div class="col-md-2 mt-2">
                                                <label class="mb-1">Campus <span class="text-danger">*</span></label>
                                                <select class="form-control form-control-sm" name="campus" id="campusold">
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
                                                <select class="form-control form-control-sm" name="schlyear" id="schlyearold">
                                                    <option disabled selected> --Select-- </option>
                                                    @foreach($currsem as $datacurrsem)
                                                        <option value="{{ $datacurrsem->qceschlyear }}">{{ $datacurrsem->qceschlyear }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 mt-2">
                                                <label class="mb-1">Semester <span class="text-danger">*</span></label>
                                                <select class="form-control form-control-sm" name="semester" id="semesterold">
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
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
        var getfacltyReadRoute = "{{ route('getFacultycamp') }}";
        var classenrollyrsecReadRoute = "{{ route('getCoursesyearsec') }}";
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
@endsection
