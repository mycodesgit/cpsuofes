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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <style>
        body {
            background: #ffffff; 
            overflow-x: hidden;
            position: relative;
        }
        .edge-blur {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0; 

            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);

            mask-image: radial-gradient(
                circle at center,
                transparent 60%,   
                black 65%    
            );

            -webkit-mask-image: radial-gradient(
                circle at center,
                transparent 60%,
                black 65%
            );
        }

        .animated-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            overflow: hidden;
        }

        .animated-bg::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;

            background-image:
                linear-gradient(rgba(80, 80, 80, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(80, 80, 80, 0.08) 1px, transparent 1px);

            background-size: 40px 40px;

            animation: moveGrid 5s linear infinite;
        }

        .animated-bg::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 30%, rgba(0,0,0,0.03), transparent 80%),
                radial-gradient(circle at 80% 70%, rgba(0,0,0,0.03), transparent 80%);
        }

        @keyframes moveGrid {
            from {
                transform: translate(0, 0);
            }
            to {
                transform: translate(-60px, -60px);
            }
        }
        .card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
        }
    </style>
</head>

<body>
    <div class="animated-bg"></div>
    <div class="edge-blur"></div>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card" style="max-width:420px; width:100%;">
            <div class="card-body p-5">
                <div class="text-center mb-3">
                    <a href="./" class="mb-4 d-inline-block">
                        <span class=" ms-2"> <img src="{{ asset('assets/images/cpsulogov4.png') }}" alt="" width="25%"></span>
                    </a>
                    <h1 class="card-title mb-5">CPSU OFES</h1>

                </div>

                <form class="needs-validation mt-3" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input id="email" type="email" class="form-control" placeholder="name@cpsu.edu.ph" required autofocus>
                        <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label d-flex justify-content-between">
                            <span>Password</span>
                            <a href="#" class="small link-primary">Forgot Password?</a>
                        </label>
                        <input id="password" type="password" class="form-control" placeholder="Password" required minlength="6">
                        <div class="invalid-feedback">Please provide a password (min 6 characters).</div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input id="remember" class="form-check-input" type="checkbox">
                            <label class="form-check-label small" for="remember">Remember me</label>
                        </div>
                    </div>

                    <button class="btn btn-success w-100" type="submit">Sign in</button>
                </form>

                <div class="text-center mt-3 small text-muted">
                    Don't have an account?
                </div>
            </div>
        </div>
    </div>

    <script type="module" src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>