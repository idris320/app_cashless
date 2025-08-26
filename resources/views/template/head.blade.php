<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>APP Cashless Ponpes Al-Furqon</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{ asset('') }}/bootstrap/img/user.jpg" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Datatables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    {{-- search data --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    

    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('') }}/bootstrap/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="{{ asset('') }}/bootstrap/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('') }}/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('') }}/bootstrap/css/style.css" rel="stylesheet">
    
    <style>
        /* Ubah warna teks link pagination */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #28a745 !important; /* Hijau Bootstrap */
        }

        /* Ubah warna saat aktif (halaman yang sedang dipilih) */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #28a745 !important;
            color: white !important;
            border: 1px solid #28a745 !important;
        }

        /* Hover effect */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #218838 !important;
            color: white !important;
            border: 1px solid #218838 !important;

        }

        /* Ganti warna biru default dengan hijau */
        .btn-primary {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
        }

        .bg-primary {
        background-color: #28a745 !important;
        }

        .text-primary {
        color: #28a745 !important;
        }

        .nav-link:hover,
        .nav-link:focus {
        outline: none !important;
        box-shadow: none !important;
        color: #28a745 !important;
        background-color: rgba(7, 44, 12, 0.1) !important;
        }

        .nav-link.active {
        color: white !important;
        background-color: #28a745 !important;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }

        :root {
            --primary: #28a745 !important;
            --light: #F3F6F9;
            --dark: #191C24;
        }

        /* Warna hijau saat switch aktif */
        .form-check-input:checked {
        background-color: #28a745; /* Bootstrap green */
        border-color: #28a745;
        }

        /* Warna toggle bulatan saat aktif */
        .form-check-input:checked::before {
        background-color: white;
        }

    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        
        @if (session('successLogin'))
        <script>
            Swal.fire({
                title: 'Success',
                text: '{{ session('successLogin') }}, {{ auth()->user()->nama }}',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#28a745'
            });
        </script>
        @endif

        {{-- alert isi form --}}
        @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#28a745'
            });
        </script>
        @elseif (session('error'))
        <script>
            Swal.fire({
                title: 'Error',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
                confirmButtonColor: '#f5171700'
            });
        </script>
        @endif
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-success" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->
