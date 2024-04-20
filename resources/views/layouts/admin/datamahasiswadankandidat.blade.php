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
            <a class="nav-link" href="admin">
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
            <a class="nav-link" href="datamahasiswadankandidat">
                <i class="fas fa-fw fa-user-graduate"></i>
                Data User</a>

            <a class="nav-link" href="datamatakuliahadmin">
                <i class="fas fa-fw fa-book-dead"></i>
                Data Mata Kuliah</a>

            <a class="nav-link" href="periodeadmin">
                <i class="fas fa-fw fa-calendar"></i>
                Setting Periode</a>

            <a class="nav-link" href="pollingadmin">
                <i class="fas fa-fw fa-vote-yea"></i>
                Voting</a>

            <a class="nav-link" href="hasilpollingadmin">
                <i class="fas fa-fw fa-poll"></i>
                Hasil Polling</a>

            <a class="nav-link" href="/change-passwordadmin">
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
                <h1 class="h3 mb-2 text-gray-800">Data Mahasiswa dan Kandidat</h1>
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <a href="add" class="btn btn-primary mb-3">Tambah Data</a>
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>ID/NRP</th>
                                    <th>Nama</th>
                                    <th>Gmail</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($tabel as $mhs)
                                    @if ($mhs -> role != "admin")
                                        <tr>
                                            <td>{{ $mhs->id }}</td>
                                            <td>{{ $mhs->name }}</td>
                                            <td>{{ $mhs->email }}</td>
                                            <td>{{ $mhs->role }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href = "{{ route('edituser', ['user' => $mhs])}}" role="button" class="btn btn-warning fas fa-edit mr-2"></a>
                                                    <form action="{{ url('hapus/'. $mhs->id) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger delete-item">Hapus</button>
                                                    </form>
                                                </div>
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
                    <span>Copyright &copy; Tugas Pemprograman Web Lanjut 2024</span>
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
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
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

{{-- Swal Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('.delete-item').on('click', function (event) {
            event.preventDefault();
            Swal.fire({
                title: "WARNING!!!",
                text: "apakah yakin ingin menghapus data ini?",
                icon: "warning",
                showCancelButton:true,
                confirmButtonText: "Yes,delete it!",
                cancelButtonText: "No, Canceled!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(this).closest('form').attr('action'),
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    });
                    window.location.reload();
                }
            });
        });
    });
</script>
</body>

</html>
@endsection
