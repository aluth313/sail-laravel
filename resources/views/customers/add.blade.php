@extends('adminlte::page')

@section('title', 'Pelanggan')

@section('content_header')
    <h1>Pelanggan</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Pelanggan</h3>
                    </div>


                    <form method="POST" action="/customers">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nama Pelanggan</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama pelanggan" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">No HP</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan no hp">
                            </div>
                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <textarea name="address" id="address" class="form-control" placeholder="Masukan alamat" cols="30" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop