@extends('app')

@section('content')

    <!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>POLLING</title>

    <!-- Custom fonts for this template -->
    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="mahasiswa">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Polling</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="mahasiswa">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                Dashboard</a>
        </li>

        <div class="sidebar-heading">
            Menu Data Master
        </div>

        <!-- Nav Item -->
        <li class="nav-item">
            <a class="nav-link" href="pollingList">
                <i class="fas fa-fw fa-book-dead"></i>
                Voting</a>
            <a class="nav-link" href="hasilpolling">
                <i class="fas fa-fw fa-poll"></i>
                Hasil Polling</a>
            <a class="nav-link" href="/change-password">
                <i class="fas fa-fw fa-poll"></i>
                Change Password</a>
        </li>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <br>
                    <h1 class="h3 mb-2 text-gray-800">Periode Polling</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Nama Polling</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                        <th>Tersisa</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($data as $periode)
                                        @php
                                            $now = date('Y-m-d H:i:s', strtotime('+8 hours'));
                                            $start = $periode->start_date;
                                            $end = $periode->end_date;
                                            $status = '';
                                            $diff = strtotime($end) - strtotime($now);
                                            $diff += 3600;
                                            $days = floor($diff / (60 * 60 * 24));
                                            $hours = floor(($diff - ($days * 60 * 60 * 24)) / 3600);
                                            $minutes = floor(($diff - ($days * 60 * 60 * 24) - ($hours * 3600)) / 60);

                                            if ($now < $start) {
                                                $status = 'Belum Dimulai';
                                            } elseif ($now > $end) {
                                                $status = 'Selesai';
                                            } else {
                                                $status = 'Berlangsung';
                                            }
                                        @endphp
                                        @if ($status == 'Berlangsung')
                                            <tr>
                                                <td>{{ $periode->nama_polling }}</td>
                                                <td>{{ date('d-m-Y H:i', strtotime($periode->start_date)) }} - {{ date('d-m-Y H:i', strtotime($periode->end_date)) }}</td>
                                                <td>
                                                    <span class="badge badge-success">{{ $status }}</span>
                                                </td>
                                                <td>
                                                    {{ $days }} Hari, {{ $hours }} Jam, {{ $minutes }} Menit
                                                </td>
                                                <td>
                                                    <a href = "{{ route('polling', ['polling' => $periode->id]) }}" role="button" class="btn btn-primary">Vote</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Tugas Pemrograman Web Lanjut 2024</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('sbadmin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('sbadmin/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('sbadmin/js/demo/datatables-demo.js') }}"></script>

</body>

</html>
@endsection
