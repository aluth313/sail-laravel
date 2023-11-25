@extends('adminlte::page')

@section('title', 'Pelanggan')

@section('content_header')
    <h1>Ubah Pelanggan</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Ubah Pelanggan</h3>
                    </div>


                    <form method="POST" action="/customers/{{$customer->id}}">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nama Pelanggan</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukan nama pelanggan" value="{{$customer->name}}" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">No HP</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan no hp" value="{{$customer->phone}}">
                            </div>
                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <textarea name="address" id="address" class="form-control" placeholder="Masukan alamat" cols="30" rows="10">{{$customer->address}}</textarea>
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