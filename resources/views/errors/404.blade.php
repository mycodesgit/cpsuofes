<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 || Page Not Found</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/cpsulogov4.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/cpsulogov4.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/cpsulogov4.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free-V6/css/all.min.css') }}">

</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="" style="max-width: 500px; width: 100%;">
            <div class="text-center">
                <h1 class="display-1 fw-bold text-danger mb-2">400</h1>
                <h2 class="card-title h4 mb-3">Page Not Found</h2>
                <p class="text-muted mb-5">Sorry, the page you're looking for doesn't exist or has been moved.</p>

                <button class="btn btn-outline-primary" onclick="refreshPage()">
                    <i class="ti ti-refresh"></i> Refresh Page
                </button>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <script>
        var getfacltyReadRoute = "{{ route('getFacultycamp') }}";
        function refreshPage() {
            location.reload();
        }
    </script>
</body>
</html>