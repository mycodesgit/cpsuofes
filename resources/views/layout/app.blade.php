<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>CPSU || OFES</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/cpsulogov4.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/cpsulogov4.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/cpsulogov4.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free-V6/css/all.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- DataTables  -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/fullcalendar.css') }}">

    <style>
        .nav-link {
            font-size: 14px;
        }

        .nav-link:hover {
            background-color: #f8f9fa;
            border-radius: 6px;
        }

        .collapse .nav-link {
            color: #555;
        }
        .sidebar .nav-link.active {
            color: #000000 !important;
            background-color: #65ac86 !important;
        }
        /* When sidebar is collapsed, remove active background */
        .sidebar.collapsed .nav-link.active,
        .sidebar.collapsed .nav-link:hover {
            background-color: transparent !important;
            color: inherit !important;
        }
        /* main {
            background-color: #f4f6f9;
        } */
        .fc-event {
            border-color: #198754; background-color: #198754;
        }
        @media (max-width: 768px) {
            .fc .fc-daygrid-day-frame {
                min-height: 45px;
            }
        }
        .card-hover {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .card-hover:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .sidebar .nav-link .fa {
            font-size: 18px !important;
        }
        .fa {
            font-family: tabler-icons !important;
            speak: none;
            font-style: normal;
            font-weight: 400;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
</head>

<body>
    <div id="overlay" class="overlay"></div>
    <!-- TOPBAR -->
    <nav id="topbar" class="navbar bg-white border-bottom fixed-top topbar px-3">
        <button id="toggleBtn" class="d-none d-lg-inline-flex btn btn-light btn-icon btn-sm ">
            <i class="fas fa-bars"></i>
        </button>

        <!-- MOBILE -->
        <button id="mobileBtn" class="btn btn-light btn-icon btn-sm d-lg-none me-2">
            <i class="ti ti-layout-sidebar-left-expand"></i>
        </button>
        <div>
            <!-- Navbar nav -->
            <ul class="list-unstyled d-flex align-items-center mb-0 gap-1">

                <!-- Bell icon -->
                <li>
                    <a class="position-relative btn-icon btn-sm btn-light btn rounded-circle" data-bs-toggle="dropdown" aria-expanded="false" href="#" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-bell">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                            <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                        </svg>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger mt-2 ms-n2">
                            2
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-0">
                        <ul class="list-unstyled p-0 m-0">
                            <li class="p-3 border-bottom ">
                                <div class="d-flex gap-3">
                                    <img src="{{ asset('assets/images/user.png') }}" alt="" class="avatar avatar-sm rounded-circle" />
                                    <div class="flex-grow-1 small">
                                        <p class="mb-0">New order received</p>
                                        <p class="mb-1">Order #12345 has been placed</p>
                                        <div class="text-secondary">5 minutes ago</div>
                                    </div>
                                </div>
                            </li>
                            <li class="p-3 border-bottom ">
                                <div class="d-flex gap-3">
                                    <img src="{{ asset('assets/images/user.png') }}" alt="" class="avatar avatar-sm rounded-circle" />
                                    <div class="flex-grow-1 small">
                                        <p class="mb-0">New user registered</p>
                                        <p class="mb-1">User @john_doe has signed up</p>
                                        <div class="text-secondary">30 minutes ago</div>
                                    </div>
                            </li>

                            <li class="p-3 border-bottom">
                                <div class="d-flex gap-3">
                                    <img src="{{ asset('assets/images/user.png') }}" alt="" class="avatar avatar-sm rounded-circle" />
                                    <div class="flex-grow-1 small">
                                        <p class="mb-0">Payment confirmed</p>
                                        <p class="mb-1">Payment of $299 has been received</p>
                                        <div class="text-secondary">1 hour ago</div>
                                    </div>
                                </div>
                            </li>
                            <li class="px-4 py-3 text-center">
                                <a href="#" class="text-primary ">View all notifications</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Dropdown -->
                <li class="ms-3 dropdown">
                    <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/images/user.png') }}" alt="" class="avatar avatar-sm rounded-circle" /> Admin Level
                    </a>
                    <div class="dropdown-menu dropdown-menu-end p-0" style="min-width: 200px;">
                        <div>
                            <div class="d-flex gap-3 align-items-center border-dashed border-bottom px-3 py-3">
                                <img src="{{ asset('assets/images/user.png') }}" alt="" class="avatar avatar-md rounded-circle" />
                                <div>
                                    <h4 class="mb-0 small">Admin Level</h4>
                                    <p class="mb-0 small">@cpsu.edu.ph</p>
                                </div>
                            </div>
                            <div class="p-3 d-flex flex-column gap-1 medium lh-lg">
                                <a href="#!" class="text-secondary">
                                    <i class="ti ti-settings"></i> <span>Account Settings</span>
                                </a>
                                <a href="#!" class="text-success">
                                    <i class="ti ti-message"></i><span> Chat Message</span>
                                </a>
                                <a href="{{ route('logout') }}" class="text-danger">
                                    <i class="ti ti-logout"></i><span> Signout</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </li>
            </ul>
        </div>

    </nav>

    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar">
        <div class="logo-area">
            <div class="d-inline-flex">
                <img src="{{ asset('assets/images/cpsulogov4.png') }}" alt="logo" width="24">
                <span class="logo-text ms-2" style="font-weight: bold">CPSU OFES</span>
            </div>
        </div>
        @include('includes.sidebar')

    </aside>

    <!-- MAINmainCONTENT -->
    <main id="content" class="content py-10">
        <div class="container-fluid">
            @yield('body')

            <div class="row">
                <div class="col-12">
                    <footer class="text-center py-2 mt-6 text-secondary fixed-bottom bg-white" style="z-index: 99">
                        <p class="mb-0">CPSU OFES V.2.0: Maintained and Managed by Management Information System Office (MISO) under the Leadership of Dr. Aladino C. Moraca.</p>
                    </footer>
                </div>
            </div>

        </div>
    </main>

    <!-- Bootstrap JS -->

    <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/fullcalendar/fullcalendar.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Validation JS -->
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    
    @if (request()->routeIs('index.calendar'))
        @include('scripts.calendarjs')
    @endif

    @if (request()->routeIs('facultyFilter'))
        @include('scripts.facultyjs')
    @endif

    @if (request()->routeIs('ratingscale.index'))
        @include('scripts.ratingscalejs')
        @include('scripts.validations.ratingscalevalidation')
    @endif

    @if (request()->routeIs('instruction.index'))
        @include('scripts.instructionjs')
        @include('scripts.validations.instructionvalidation')
    @endif

    @if (request()->routeIs('category.index'))
        @include('scripts.categoryjs')
        @include('scripts.validations.categoryvalidation')
    @endif

    @if (request()->routeIs('question.index'))
        @include('scripts.questionjs')
        @include('scripts.validations.questionvalidation')
    @endif

    @if (request()->routeIs('subquestion.index'))
        @include('scripts.subquestionjs')
        @include('scripts.validations.subquestionvalidation')
    @endif

    @if (request()->routeIs('semester.index'))
        @include('scripts.semesterjs')
        @include('scripts.validations.semestervalidation')
    @endif

    @if (request()->routeIs('studaccountsearch.store'))
        @include('scripts.studaccountjs')
    @endif

    @if (request()->routeIs('user.index'))
        @include('scripts.userjs')
    @endif

    @if (request()->routeIs('printeval.index'))
        @include('scripts.getfacultyjs')
        @include('scripts.getclassenrolljs')
        @include('scripts.validations.printevalvalidation')
    @endif

    @if (request()->routeIs('subprintstudent_searchresultStore'))
        @include('scripts.evalsubmissionprintjs')
    @endif

    @if (request()->routeIs('summaryevalresult.index'))
        @include('scripts.getfacultyjs')
        @include('scripts.validations.evaluationresultvalidation')
    @endif

    @if (request()->routeIs('conducted.index'))
        @include('scripts.getfacultyjs')
    @endif

    @if (request()->routeIs('summaryEvalStore'))
        @include('scripts.getfacultyjs')
        @include('scripts.validations.evaluationresultvalidation')
    @endif
</body>

</html>