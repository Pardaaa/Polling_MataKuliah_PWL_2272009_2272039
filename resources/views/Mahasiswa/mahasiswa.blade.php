@section('web-content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kartu Keluarga Form</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Kartu Keluarga Form</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ implode('', $errors->all(':message')) }}
                </div>
            @endif
            <div class="card p-4">
                <form method="post" action="">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kk-id">Nomor Kartu Keluarga</label>
                            <input type="text" class="form-control" id="kk-id" placeholder="Nomor KK" name="id" required autofocus maxlength="15">
                        </div>
                        <div class="form-group">
                            <label for="nama-kk">Nama Kepala Keluarga</label>
                            <input type="text" maxlength="100" class="form-control" id="nama-kk" placeholder="Contoh: John Doe" required name="kepala_keluarga">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    <!-- /.content -->
@endsection

@section('spc-css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}"
@endsection

@section('spc-js')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $('#table-kk'). DataTable();
    </script>
@endsection
