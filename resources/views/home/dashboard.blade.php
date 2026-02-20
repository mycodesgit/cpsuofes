@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Dashboard</h1>

                <div class="card bg-success bg-opacity-10 border border-success border-opacity-25 rounded-2 mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-shape icon-md bg-success text-white rounded-2">
                                <i class="ti ti-user fs-4"></i>
                            </div>
                            <div>
                                <h1 class="mb-0 fs-2">Welcome back, {{ auth()->user()->fname }}!</h1>
                                <p class="text-secondary mb-0 small">Here's what's happening with your account today.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card p-4 bg-secondary bg-opacity-10 border border-secondary border-opacity-25 rounded-2 mb-3">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <select name="" id="" class="form-control" placeholder="Search Campus">
                                    <option value=""> --Select Campus-- </option>
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
                            <div class="col-md-6">
                                <select name="" id="" class="form-control" placeholder="Search Campus">
                                    <option value=""> --Select Rating Period-- </option>
                                    @foreach($currsem as $datacurrsem)
                                        <option value="{{ $datacurrsem->qceschlyear }}" data-from="{{ $datacurrsem->qceratingfrom }}" data-to="{{ $datacurrsem->qceratingto }}">
                                            {{ $datacurrsem->qceschlyear }} ({{ $datacurrsem->qceratingfrom }} - {{ $datacurrsem->qceratingto }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>   
                    </form>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-lg-3 col-12">
                        <div class="card p-4 bg-secondary bg-opacity-10 border border-secondary border-opacity-25 rounded-2">
                            <div class="d-flex gap-3 ">
                                <div class="icon-shape icon-md bg-secondary text-white rounded-2">
                                    <i class="ti ti-report-analytics fs-4"></i>
                                </div>
                                <div>
                                    <h1 class="mb-3 fs-2">Grand Total</h1>
                                    <h1 class="fw-bold mb-0">68</h1>
                                    <p class="text-secondary mb-0 small">+5% since last month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="card p-4  bg-secondary bg-opacity-10 border border-secondary border-opacity-25 rounded-2">
                            <div class="d-flex gap-3 ">
                                <div class="icon-shape icon-md bg-secondary text-white rounded-2">
                                    <i class="ti ti-report-analytics fs-4"></i>
                                </div>
                                <div>
                                    <h1 class="mb-3 fs-2">Institutional</h1>
                                    <h1 class="fw-bold mb-0">68</h1>
                                    <p class="text-secondary mb-0 small">+5% since last month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="card p-4  bg-secondary bg-opacity-10 border border-secondary border-opacity-25 rounded-2">
                            <div class="d-flex gap-3 ">
                                <div class="icon-shape icon-md bg-secondary text-white rounded-2">
                                    <i class="ti ti-report-analytics fs-4"></i>
                                </div>
                                <div>
                                    <h1 class="mb-3 fs-2">Total Faculty</h1>
                                    <h1 class="fw-bold mb-0">68</h1>
                                    <p class="text-secondary mb-0 small">+5% since last month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="card p-4  bg-secondary bg-opacity-10 border border-secondary border-opacity-25 rounded-2">
                            <div class="d-flex gap-3 ">
                                <div class="icon-shape icon-md bg-secondary text-white rounded-2">
                                    <i class="ti ti-report-analytics fs-4"></i>
                                </div>
                                <div>
                                    <h1 class="mb-3 fs-2">Total Responses</h1>
                                    <h1 class="fw-bold mb-0">68</h1>
                                    <p class="text-secondary mb-0 small">+5% since last month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection