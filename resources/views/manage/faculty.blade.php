@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Faculty</h1>
                <div>
                    <div>
                        <div class="row mb-5 g-5">
                            <div class="col-xl-3 col-md-6 col-12">
                                <a href="{{ route('facultyFilter', ['campus' => encrypt('MC')]) }}">
                                    <div class="card bg-secondary bg-opacity-10 border-secondary border-opacity-25 card-hover">
                                        <div class="card-body p-5">
                                            <div class="d-flex flex-column">
                                                <span class="fs-2 fw-bold mb-0 d-block">Main</span>
                                                <span class="fs-6">Campus - Faculty</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <a href="{{ route('facultyFilter', ['campus' => encrypt('VC')]) }}">
                                    <div class="card bg-secondary bg-opacity-10 border-secondary border-opacity-25 card-hover">
                                        <div class="card-body p-5">
                                            <div class="d-flex flex-column">
                                                <span class="fs-2 fw-bold mb-0 d-block">Victorias</span>
                                                <span class="fs-6">Campus - Faculty</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <a href="{{ route('facultyFilter', ['campus' => encrypt('SCC')]) }}">
                                    <div class="card bg-secondary bg-opacity-10 border-secondary border-opacity-25 card-hover">
                                        <div class="card-body p-5">
                                            <div class="d-flex flex-column">
                                                <span class="fs-2 fw-bold mb-0 d-block">San Carlos</span>
                                                <span class="fs-6">Campus - Faculty</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <a href="{{ route('facultyFilter', ['campus' => encrypt('HC')]) }}">
                                    <div class="card bg-secondary bg-opacity-10 border-secondary border-opacity-25 card-hover">
                                        <div class="card-body p-5">
                                            <div class="d-flex flex-column">
                                                <span class="fs-2 fw-bold mb-0 d-block">Hinigaran</span>
                                                <span class="fs-6">Campus - Faculty</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <a href="{{ route('facultyFilter', ['campus' => encrypt('MP')]) }}">
                                    <div class="card bg-secondary bg-opacity-10 border-secondary border-opacity-25 card-hover">
                                        <div class="card-body p-5">
                                            <div class="d-flex flex-column">
                                                <span class="fs-2 fw-bold mb-0 d-block">Moises Padilla</span>
                                                <span class="fs-6">Campus - Faculty</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <a href="{{ route('facultyFilter', ['campus' => encrypt('IC')]) }}">
                                    <div class="card bg-secondary bg-opacity-10 border-secondary border-opacity-25 card-hover">
                                        <div class="card-body p-5">
                                            <div class="d-flex flex-column">
                                                <span class="fs-2 fw-bold mb-0 d-block">Ilog</span>
                                                <span class="fs-6">Campus - Faculty</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <a href="{{ route('facultyFilter', ['campus' => encrypt('CA')]) }}">
                                    <div class="card bg-secondary bg-opacity-10 border-secondary border-opacity-25 card-hover">
                                        <div class="card-body p-5">
                                            <div class="d-flex flex-column">
                                                <span class="fs-2 fw-bold mb-0 d-block">Candoni</span>
                                                <span class="fs-6">Campus - Faculty</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <a href="{{ route('facultyFilter', ['campus' => encrypt('CC')]) }}">
                                    <div class="card bg-secondary bg-opacity-10 border-secondary border-opacity-25 card-hover">
                                        <div class="card-body p-5">
                                            <div class="d-flex flex-column">
                                                <span class="fs-2 fw-bold mb-0 d-block">Cauayan</span>
                                                <span class="fs-6">Campus - Faculty</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <a href="{{ route('facultyFilter', ['campus' => encrypt('SP')]) }}">
                                    <div class="card bg-secondary bg-opacity-10 border-secondary border-opacity-25 card-hover">
                                        <div class="card-body p-5">
                                            <div class="d-flex flex-column">
                                                <span class="fs-2 fw-bold mb-0 d-block">Sipalay</span>
                                                <span class="fs-6">Campus - Faculty</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <a href="{{ route('facultyFilter', ['campus' => encrypt('HinC')]) }}">
                                    <div class="card bg-secondary bg-opacity-10 border-secondary border-opacity-25 card-hover">
                                        <div class="card-body p-5">
                                            <div class="d-flex flex-column">
                                                <span class="fs-2 fw-bold mb-0 d-block">Hinobaan</span>
                                                <span class="fs-6">Campus - Faculty</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
