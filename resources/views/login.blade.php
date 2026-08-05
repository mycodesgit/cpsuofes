<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>CPSU OFES || Sign In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/cpsulogov4.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/cpsulogov4.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/cpsulogov4.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        /* Base Container & Background Settings */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background-color: #f8fafc;
            transition: background-color 0.3s ease;
        }

        /* --- Dark Mode Radial Green Background --- */
        [data-bs-theme="dark"] .login-wrapper {
            background: radial-gradient(circle at 20% 30%, #0d3822 0%, #051a10 60%, #020d08 100%) !important;
        }

        /* Subtle Background Grid overlay in Dark Mode */
        [data-bs-theme="dark"] .login-wrapper::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
            pointer-events: none;
        }

        /* Base Canvas Container for Background Particles */
        .bg-particles-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        /* Floating Animated Background Icons */
        .bg-particle {
            position: absolute;
            bottom: -50px;
            color: rgba(25, 135, 84, 0.15); /* Light green tint in Light mode */
            font-size: 1.8rem;
            animation: floatUp 15s infinite linear;
            pointer-events: none;
        }

        .bg-particle:nth-child(1) { left: 10%; font-size: 2.2rem; animation-duration: 18s; animation-delay: 0s; }
        .bg-particle:nth-child(2) { left: 25%; font-size: 1.4rem; animation-duration: 12s; animation-delay: 2s; }
        .bg-particle:nth-child(3) { left: 45%; font-size: 2.5rem; animation-duration: 22s; animation-delay: 4s; }
        .bg-particle:nth-child(4) { left: 65%; font-size: 1.8rem; animation-duration: 16s; animation-delay: 1s; }
        .bg-particle:nth-child(5) { left: 85%; font-size: 2.0rem; animation-duration: 14s; animation-delay: 5s; }
        .bg-particle:nth-child(6) { left: 92%; font-size: 1.5rem; animation-duration: 19s; animation-delay: 3s; }

        @keyframes floatUp {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }
            15% {
                opacity: 0.6;
            }
            85% {
                opacity: 0.6;
            }
            100% {
                transform: translateY(-110vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* Hero Text Styling */
        .hero-title {
            font-size: 2.75rem;
            font-weight: 800;
            line-height: 1.15;
            color: #0f172a;
        }

        .hero-title .highlight {
            color: #198754;
        }

        [data-bs-theme="dark"] .hero-title {
            color: #ffffff;
        }

        [data-bs-theme="dark"] .hero-title .highlight {
            color: #f59e0b; /* Golden contrast accent for dark green background */
        }

        .hero-badge {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
            border: 1px solid rgba(25, 135, 84, 0.2);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 0.35rem 0.85rem;
            border-radius: 50rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        [data-bs-theme="dark"] .hero-badge {
            background-color: rgba(245, 158, 11, 0.12);
            color: #f59e0b;
            border-color: rgba(245, 158, 11, 0.25);
        }

        .feature-pill {
            background-color: rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.08);
            color: #475569;
            font-size: 0.825rem;
            padding: 0.4rem 0.85rem;
            border-radius: 50rem;
        }

        [data-bs-theme="dark"] .feature-pill {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.12);
            color: #cbd5e1;
        }

        /* Elevate Content over background particles */
        .login-card-wrapper {
            position: relative;
            z-index: 1;
        }

        /* Dark Mode Card Custom Overrides */
        [data-bs-theme="dark"] .card {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        [data-bs-theme="dark"] .form-control {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        [data-bs-theme="dark"] .form-control::placeholder {
            color: #64748b !important;
        }
        [data-bs-theme="dark"] .text-muted,
        [data-bs-theme="dark"] .text-secondary {
            color: #94a3b8 !important;
        }
        [data-bs-theme="dark"] .bg-particle {
            color: rgba(255, 255, 255, 0.07);
        }
    </style>
</head>

<body>
    <div class="login-wrapper p-3 p-md-4">
        
        {{-- Floating Background Icons / Particles --}}
        <div class="bg-particles-container">
            <i class="ti ti-shield bg-particle"></i>
            <i class="ti ti-lock bg-particle"></i>
            <i class="ti ti-key bg-particle"></i>
            <i class="ti ti-motorbike bg-particle"></i>
            <i class="ti ti-file-text bg-particle"></i>
            <i class="ti ti-checkup-list bg-particle"></i>
        </div>

        {{-- Theme Switcher Button (Top Right) --}}
        <div class="position-absolute top-0 end-0 p-3" style="z-index: 10;">
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle p-2" id="themeToggleBtn" title="Toggle Light/Dark Mode" style="width: 38px; height: 38px;">
                <i class="ti ti-moon fs-5" id="themeIcon"></i>
            </button>
        </div>

        <div class="container login-card-wrapper">
            <div class="row align-items-center justify-content-center g-4 g-lg-5">
                
                {{-- Left Column: Hero Branding Section --}}
                <div class="col-lg-6 col-xl-6 text-center text-lg-start pe-lg-4 d-none d-lg-block">
                    <div class="mb-3">
                        <img src="{{ asset('assets/images/cpsulogov4.png') }}" alt="Seal Logo" style="width: 100px; height: 100px;" class="img-fluid mb-3">
                        <div>
                            <span class="hero-badge">
                                <i class="ti ti-building-landmark"></i> Central Philippines State University 
                            </span>
                        </div>
                    </div>

                    <h1 class="hero-title mb-3">
                        <span class="highlight">Online Faculty</span> <br>
                        Evaluation System
                    </h1>

                    <p class="text-secondary fs-6 mb-4 me-lg-4" style="max-width: 520px;">
                        A secure and efficient platform for student evaluations, instructor performance tracking, feedback collection, and academic quality assurance — all in one centralized system.
                    </p>

                    <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-lg-start">
                        <span class="feature-pill"><i class="ti ti-check text-success me-1"></i> Instructor Ratings</span>
                        <span class="feature-pill"><i class="ti ti-check text-success me-1"></i> Feedback Management</span>
                        <span class="feature-pill"><i class="ti ti-check text-success me-1"></i> Performance Reports</span>
                    </div>
                </div>

                {{-- Right Column: Sign In Card --}}
                <div class="col-12 col-sm-9 col-md-7 col-lg-5 col-xl-4">
                    <div class="card border-1 shadow-lg rounded-4">
                        <div class="card-body p-4 p-sm-5">
                            
                            {{-- System Logo --}}
                            <div class="text-center mb-4">
                                <div class="mb-3 d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-circle" style="width: 64px; height: 64px;">
                                    <i class="ti ti-lock fs-2"></i>
                                </div>
                                <h4 class="fw-bold mb-1">Welcome Back</h4>
                                <p class="text-muted small">Sign in to your OFES account</p>
                            </div>

                            <form action="{{ route('empstudlogin') }}" method="post">
                                @csrf
                                {{-- Username Field --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-secondary">Email</label>
                                    <div class="position-relative">
                                        <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                                            <i class="ti ti-mail fs-5"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control ps-5 py-2-5" placeholder="Enter Email" style="padding-left: 2.75rem !important;">
                                    </div>
                                </div>

                                {{-- Password Field --}}
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label fw-semibold small text-secondary mb-0">Password</label>
                                    </div>
                                    <div class="position-relative">
                                        <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                                            <i class="ti ti-key fs-5"></i>
                                        </span>
                                        <input type="password" name="password" class="form-control ps-5 pe-5 py-2-5" id="passwordInput" placeholder="••••••••" style="padding-left: 2.75rem !important;">
                                        <button type="button" class="btn border-0 position-absolute top-50 end-0 translate-middle-y me-2 text-muted p-1" id="togglePassword">
                                            <i class="ti ti-eye fs-5" id="passwordIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- Remember Me Checkbox --}}
                                <div class="form-check mb-1">
                                </div>

                                {{-- Submit Button --}}
                                <button type="submit" class="btn btn-success w-100 py-2.5 fw-semibold rounded-3 mb-3 shadow-sm">
                                    <i class="ti ti-login me-1"></i> Sign In
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Footer Note --}}
                    <div class="text-center mt-4">
                        <small class="text-muted">CPSU OFES V.2.0: Maintained and Managed by Management Information System Office (MISO) under the Leadership of Dr. Aladino C. Moraca.</small>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- JS Libraries --}}
    <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/contextmenu.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    {{-- Page Logic --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toastr Alerts
            @if(session('error'))
                toastr.error("{{ session('error') }}", "Error", {
                    closeButton: false,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 10000
                });
            @endif

            @if(session('success'))
                toastr.success("{{ session('success') }}", "Success", {
                    closeButton: false,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 10000
                });
            @endif

            // Dark/Light Theme Switcher Logic
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');
            const htmlElement = document.documentElement;

            // Force default to 'light' — ignore system preference
            const savedTheme = localStorage.getItem('theme') || 'light';
            setTheme(savedTheme);

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function () {
                    const currentTheme = htmlElement.getAttribute('data-bs-theme') || 'light';
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    setTheme(newTheme);
                });
            }

            function setTheme(theme) {
                htmlElement.setAttribute('data-bs-theme', theme);
                document.body.setAttribute('data-bs-theme', theme);
                localStorage.setItem('theme', theme);

                if (theme === 'dark') {
                    themeIcon.className = 'ti ti-sun fs-5 text-warning';
                } else {
                    themeIcon.className = 'ti ti-moon fs-5';
                }
            }

            // Password Show/Hide Toggle Logic
            const togglePasswordBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('passwordInput');
            const passwordIcon = document.getElementById('passwordIcon');

            if (togglePasswordBtn && passwordInput && passwordIcon) {
                togglePasswordBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    
                    if (isPassword) {
                        passwordIcon.classList.remove('ti-eye');
                        passwordIcon.classList.add('ti-eye-off');
                    } else {
                        passwordIcon.classList.remove('ti-eye-off');
                        passwordIcon.classList.add('ti-eye');
                    }
                });
            }
        });
    </script>
</body>
</html>