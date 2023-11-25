@extends('adminlte::page')

@section('title', 'Akun')

@section('content_header')
    <h1>Akun</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Ubah Akun</h3>
                    </div>
                    <form method="POST" action="/account/{{ $user->id }}">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Masukkan nama" value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Masukkan email" value="{{ $user->email }}" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Ubah Password</h3>
                    </div>
                    <form method="POST" action="/account/change-password/{{ $user->id }}">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="current_password">Password saat ini</label>
                                <input type="password" class="form-control" id="current_password" name="current_password"
                                    placeholder="Masukkan Password Saat Ini" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    placeholder="Masukkan Password Baru" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ session('status') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    @endif
@stop
