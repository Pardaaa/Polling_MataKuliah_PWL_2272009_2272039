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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Polling</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="prodi">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    Dashboard</a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menu Data Master
            </div>

            <!-- Nav Item -->
            <li class="nav-item">
                <a class="nav-link" href="datamahasiswa">
                    <i class="fas fa-fw fa-user-graduate"></i>
                    Data Mahasiswa</a>

                <a class="nav-link" href="datamatakuliah">
                    <i class="fas fa-fw fa-book-dead"></i>
                    Data Mata Kuliah</a>

                <a class="nav-link" href="periode">
                    <i class="fas fa-fw fa-calendar"></i>
                    Sistem Periode</a>

                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-poll"></i>
                    Hasil Polling</a>
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
                    <h1 class="h3 mb-2 text-gray-800">Data Periode Polling</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Polling</h6>
                            <a href="{{ route('addpolling') }}" class="btn btn-primary">Tambah Periode</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Polling</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                            <th>Tersisa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $periode)
                                        <tr>
                                            <td>{{ $periode->id }}</td>
                                            <td>{{ $periode->nama_polling }}</td>
                                            <td>{{ date('d-m-Y H:i', strtotime($periode->start_date)) }} - {{ date('d-m-Y H:i', strtotime($periode->end_date)) }}</td>
                                            <td>
                                                @php
                                                $now = date('Y-m-d H:i:s', strtotime('+8 hours'));
                                                $start = $periode->start_date;
                                                $end = $periode->end_date;
                                                @endphp
                                                @if ($now < $start) <span class="badge badge-warning">Belum Dimulai</span>
                                                    @elseif ($now> $end)
                                                    <span class="badge badge-danger">Selesai</span>
                                                    @else
                                                    <span class="badge badge-success">Berlangsung</span>
                                                    @endif
                                            </td>
                                            <td>
                                                @php
                                                $diff = strtotime($end) - strtotime($now);
                                                $days = floor($diff / (60 * 60 * 24));
                                                $hours = floor(($diff - $days * 60 * 60 * 24) / (60 * 60));
                                                $minutes = floor(($diff - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
                                                @endphp
                                                @if ($now < $start) - @elseif ($now> $end)
                                                    -
                                                    @else
                                                    {{ $days }} Hari, {{ $hours }} Jam, {{ $minutes }} Menit
                                                    @endif
                                            </td>
                                        </tr>
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
                        <span>Copyright &copy; Your Website 2020</span>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

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
