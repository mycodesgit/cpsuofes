@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Dashboard</h1>

                <div class="row g-4 mb-5">
                    <div class="col-lg-3 col-12">
                        <div class="card card-animate">
                            <div class="card-body p-6">
                                <div class="d-flex justify-content-between pb-2">
                                    <div>
                                        <h3 class="fw-bold h1">{{ $currfacultySched }}</h3>
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
                                        <h3 class="fw-bold h1">{{ $currenrolled }}</h3>
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
                                        <h3 class="fw-bold h1">{{ $currresponses }}</h3>
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
                                                5 => 'text-success',   
                                                4 => 'text-success',   
                                                3 => 'text-warning',   
                                                2 => 'text-orange',    
                                                1 => 'text-danger'    
                                            ];
                                        @endphp
                                        <ul class="chart-legend clearfix mt-6" style="list-style: none;">
                                            <h5 class="mb-3">Colleges:</h5>
                                            @foreach ($ratecollege as $ratecolleges)
                                                <li>
                                                    <i class="fas fa-circle {{ $ratecolleges->colcolors ?? 'text-secondary' }}"></i>
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
                                <h3 class="h5 mb-0"><i class="ti ti-chart-area"></i> Department Performance Overview</h3>
                            </div>
                            <div class="card-body p-6">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Rank</th>
                                                        <th>Department</th>
                                                        <th>Avg Grand Total</th>
                                                        <th>Avg Rating</th>
                                                        <th>Area A</th>
                                                        <th>Area B</th>
                                                        <th>Area C</th>
                                                        <th>Area D</th>
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
    </script>
@endsection
