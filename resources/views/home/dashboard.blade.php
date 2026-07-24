@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Dashboard</h1>
                <div class="row g-4 mb-5">
                    <div class="col-lg-12">
                        <div class="card card-animate bg-light">
                            <div class="card-body">
                                <form id="filterForm">
                                    <div class="form-group mb-3">
                                        <div class="row g-3">
                                            {{-- <div class="col-md-4">
                                                <label>Campus: <span class="text-danger">*</span></label>
                                                <select name="campus" id="campus" class="form-control form-control-sm">
                                                    <option value=""> --Select-- </option>
                                                    @foreach ($campuses as $campus)
                                                        <option value="{{ $campus->code }}">{{ $campus->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                            <div class="col-md-4">
                                                <label>Rating Period: <span class="text-danger">*</span></label>
                                                <select name="ratingperiod" id="ratingperiod" class="form-control form-control-sm">
                                                    <option value=""> --Select-- </option>
                                                    @foreach ($currsem as $currsemesterschlyear)
                                                        <option value="{{ $currsemesterschlyear->id }}">{{ $currsemesterschlyear->qceratingfrom }} - {{ $currsemesterschlyear->qceratingto }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-success btn-block btn-sm">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12">
                        <div class="card card-animate">
                            <div class="card-body p-6">
                                <div class="d-flex justify-content-between pb-2">
                                    <div>
                                        <h3 id="facultyCount" class="fw-bold h1">{{ $currfacultySched }}</h3>
                                        <span>Total Faculty</span>
                                    </div>
                                    <div>
                                        <i class="ti ti-user-code fs-1 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12">
                        <div class="card card-animate">
                            <div class="card-body p-6">
                                <div class="d-flex justify-content-between pb-2">
                                    <div>
                                        <h3 id="studentCount" class="fw-bold h1">{{ $currenrolled }}</h3>
                                        <span>Total Students</span>
                                    </div>
                                    <div>
                                        <i class="ti ti-user-bolt fs-1 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12">
                        <div class="card card-animate">
                            <div class="card-body p-6">
                                <div class="d-flex justify-content-between pb-2">
                                    <div>
                                        <h3 id="responseCount" class="fw-bold h1">{{ $currresponses }}</h3>
                                        <span>Total Responses</span>
                                    </div>
                                    <div>
                                        <i class="ti ti-user-check fs-1 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12">
                        <div class="card card-animate">
                            <div class="card-body p-6">
                                <div class="d-flex justify-content-between pb-2">
                                    <div>
                                        <h3 class="fw-bold h1">{{ $currevalstat->statuseval }}</h3>
                                        <span>Evaluation Status</span>
                                    </div>
                                    <div>
                                        <i class="ti ti-square-toggle fs-1 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-header d-flex justify-content-between align-items-center bg-transparent px-4 py-3">
                                <h3 class="h5 mb-0">
                                    <i class="ti ti-chart-pie"></i> Number of Students
                                    <span style="font-size: 12pt" class="text-warning">Per Colleges</span>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <canvas id="collegesPieChart" style="height: 250px;"></canvas>
                                    </div>
                                    <div class="col-md-6">
                                        @php
                                            $colors = [
                                                'CAF' => '#108d6d',   
                                                'CAS' => '#ed2e40',   
                                                'CBM' => '#e83e8c',   
                                                'CCS' => '#6610f2',    
                                                'CJE' => '#6c757d',    
                                                'COE' => '#fd7e14',    
                                                'CTE' => '#007bff',    
                                            ];
                                        @endphp

                                        <ul class="chart-legend clearfix mt-6" style="list-style: none;">
                                            <h5 class="mb-3">Colleges:</h5>
                                            @foreach ($ratecollege as $ratecolleges)
                                                <li>
                                                    <i class="fas fa-circle"
                                                    style="color: {{ $colors[$ratecolleges->college_abbr] ?? '#6c757d' }}"></i>
                                                    {{ $ratecolleges->college_name }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-header d-flex justify-content-between align-items-center bg-transparent px-4 py-3">
                                <h3 class="h5 mb-0">
                                    <i class="ti ti-chart-bar"></i> Colleges Summary
                                    <span style="font-size: 12pt" class="text-warning">Faculty by Rating Category</span>
                                </h3>
                            </div>
                            <div class="card-body">
                                <canvas id="departmentBarChart" style="height: 250px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-12">
                        <div class="card card-animate">
                            <div class="card-header d-flex justify-content-between align-items-center bg-transparent px-4 py-3">
                                <h3 class="h5 mb-0"><i class="ti ti-chart-area"></i> Colleges per year level response overview</h3>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-2 p-2">
                                            <table id="evalresponseTable" class="table table-striped" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Colleges</th>
                                                        <th>Program</th>
                                                        <th>Responses</th>
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
            </div>
        </div>
    </div>

    <script>
        const deptLabels = @json($labels);
        const deptData = @json($data);
        const deptColors  = @json($colors);

        var dashevalresponseReadRoute = "{{ route('getevalresponse') }}";
    </script>

    
@endsection
