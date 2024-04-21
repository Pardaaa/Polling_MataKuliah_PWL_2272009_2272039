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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <h1 class="h3 mb-2 text-gray-800 text-center">Polling</h1>
                    <div class="container col-l-12">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        @if (isset($data))
                                        <h5 class="card-title text-center">Polling dibuka</h5>
                                        <h4 class="card-title text-center"><b>{{ $data->nama_polling }}</b></h4>
                                            <form id="pollingForm" action="{{ route('savepolling') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="polling_id" value="{{ $data->id }}">
                                                <h3>Pilih Mata Kuliah:</h3>
                                                <h6 style="color:Red;font-weight: bold">Pilih Mata Kuliah (Maksimal 9 SKS)</h6>
                                                @foreach ($datamatakuliah as $polling)
                                                    <div class="form-check">
                                                        @php
                                                            $user = auth()->user();
                                                            $isChecked = $user->hasilpolling->contains('kode_mk', $polling->kode_mk);
                                                        @endphp
                                                        <input class="form-check-input" type="checkbox" name="matakuliah[]" id="matakuliah_{{ $polling->kode_mk }}" value="{{ $polling->kode_mk }}" data-sks="{{ $polling->sks }}" {{ $isChecked ? 'checked ' : '' }}>
                                                        <label class="form-check-label" for="matakuliah_{{ $polling->kode_mk }}">
                                                            {{ $polling->kode_mk }} | {{ $polling->nama_mk }} | {{ $polling->sks }} SKS
                                                            @if ($isChecked)
                                                                <span style="color: red;font-weight: bold">| Sudah dipilih sebelumnya</span>
                                                            @endif
                                                        </label>
                                                    </div>
                                                @endforeach
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        @else
                                        <h5 class="card-title text-center">Polling belum dibuka</h5>
                                        @endif
                                    </div>
                                </div>
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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var checkboxes = document.querySelectorAll('.form-check-input');
            var pollingForm = document.getElementById('pollingForm'); // Menambahkan ID pada form

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var sksTerpilih = 0;
                    var selectedCheckboxes = document.querySelectorAll('.form-check-input:checked');
                    selectedCheckboxes.forEach(function(cb) {
                        sksTerpilih += parseInt(cb.getAttribute('data-sks'), 10);
                    });

                    // Memperbaiki logika pemeriksaan SKS
                    if (sksTerpilih >= 9) {
                        checkboxes.forEach(function(cb) {
                            if (!cb.checked) {
                                cb.disabled = true;
                            }
                        });
                    } else {
                        checkboxes.forEach(function(cb) {
                            cb.disabled = false;
                        });
                    }
                });
            });

            pollingForm.addEventListener('submit', function(event) {
                var sksTerpilih = 0;
                var selectedCheckboxes = document.querySelectorAll('.form-check-input:checked');
                selectedCheckboxes.forEach(function(cb) {
                    sksTerpilih += parseInt(cb.getAttribute('data-sks'), 10);
                });

                // Memperbaiki pengecekan status pemilihan
                if (selectedCheckboxes.length === 0) {
                    // Jika pengguna tidak memilih apapun
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Anda harus memilih setidaknya satu mata kuliah!'
                    });
                } else if (sksTerpilih > 9) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Maaf, Anda hanya bisa memilih maksimal 9 SKS!'
                    });
                } else {
                    // Jika belum pernah memilih, tampilkan konfirmasi penyimpanan data polling
                    event.preventDefault();
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: "Anda akan menyimpan data polling ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, simpan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika dikonfirmasi, kirimkan formulir
                            pollingForm.submit();
                        }
                    });
                }
            });

            // Memperbaiki pengecekan status pemilihan
            if (localStorage.getItem('hasSelected') === 'true') {
                hasSelected = true;
                checkboxes.forEach(function(checkbox) {
                    checkbox.disabled = true;
                });
            }
        });
    </script>
</body>

</html>
@endsection
