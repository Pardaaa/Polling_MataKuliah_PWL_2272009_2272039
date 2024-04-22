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
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="prodi">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Polling</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="datamatakuliah">
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
            <a class="nav-link" href="{{ route('datamahasiswadankandidat') }}">
                <i class="fas fa-fw fa-user-graduate"></i>
                Data User</a>

            <a class="nav-link" href="{{route('datamatakuliahadmin')}}">
                <i class="fas fa-fw fa-book-dead"></i>
                Data Mata Kuliah</a>

            <a class="nav-link" href="/periodeadmin">
                <i class="fas fa-fw fa-calendar"></i>
                Setting Periode</a>

            <a class="nav-link" href="/pollingListAdmin">
                <i class="fas fa-fw fa-vote-yea"></i>
                Voting</a>

            <a class="nav-link" href="/hasilpollingadmin">
                <i class="fas fa-fw fa-poll"></i>
                Hasil Polling</a>

            <a class="nav-link" href="/change-passwordadmin">
                <i class="fas fa-fw fa-poll"></i>
                Change Password</a>
        </li>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column mb-5">

        <!-- Main Content -->
        <div id="content">

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Edit Data Mata Kuliah</h1>

            </div>
            <!-- /.container-fluid -->
            <form action=" {{ route('updatematakuliahadmin', ['matkul' => $mhs]) }} " method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <label style="color:black;" for="">Kode Mata Kuliah</label>
                    <input type="text" class="form-control mb-4" name="kode_mk" id="kode_mk" aria-describedby="helpId" placeholder="Contoh: IN240" value="{{ $mhs -> kode_mk }}">
                    <label style="color:black;" for="">Nama Mata Kuliah</label>
                    <input type="text" class="form-control mb-4" name="nama_mk" id="nama_mk" aria-describedby="helpId" placeholder="Contoh: Pemrogramman Web Lanjut" value="{{ $mhs -> nama_mk }}">
                    <label style="color:black;" for="">SKS</label>
                    <input type="text" class="form-control mb-4" name="sks" id="sks" aria-describedby="helpId" placeholder="Contoh: 4" value="{{ $mhs -> sks }}">
                    <br>
                    <button class="btn btn-primary" type="submit">Edit Mata Kuliah</button>
                </div>
            </form>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('form').submit(function(event) {
            event.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var data = form.serialize();

            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Data Berhasil Diedit',
                        }).then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                window.location.href = '/datamatakuliahadmin';
                            }
                        });
                    } else {
                        var errors = response.errors.join('<br>');
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: errors,
                        });
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>

</body>

</html>
@endsection
