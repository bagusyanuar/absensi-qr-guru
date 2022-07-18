@extends('admin.layout')

@section('css')
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif

    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Gagal", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
        </script>
    @endif
    <div class="container-fluid pt-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman QR Code</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/absen">Daftar Absen</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tambah
                </li>
            </ol>
        </div>
        <div class="w-100 p-2">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-6 col-sm-11">
                    <div class="card">
                        <div class="card-body text-center">
                                {!! QrCode::size(250)->generate($data->code); !!}
                            <div class="font-weight-bold">
                                {{ $data->code }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
