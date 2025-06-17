<div>
    <link rel="icon" href="{{ asset('/template/img/logo.ico') }}" type="image/x-icon" />

    <!-- Custom fonts for this template-->
    <link href="{{ asset('/template/vendor/fontawesome-free/css/all.min.css ') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- @vite(['resources/css/app.css']); --}}

    <!-- Custom styles for this template-->
    <link href="{{ asset('/template/css/sb-admin-2.min.css ') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- @vite(['resources/css/style.css']); --}}

    <style>
        .c_bg-primary {
            background-color: #FFFFFF !important;
            background-image: linear-gradient(180deg, #FFFFFF 10%, #FAFAFA 100%);
            background-size: cover;
        }

        #registrationCard>.card-body {
            background: #D1E7DD !important;
        }

        .c_btn-primary {
            color: #fff;
            background-color: #4F772D;
            border-color: #4F772D;
        }
    </style>
</div>
