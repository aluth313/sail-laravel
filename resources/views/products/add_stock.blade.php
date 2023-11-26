@extends('adminlte::page')

@section('title', 'Tambah Stok')

@section('content_header')
    <h1>Tambah Stok</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{$product->name}}</h3>
                    </div>


                    <form method="POST" action="/products/add-stock/{{$product->id}}">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <h5>Stok saat ini: <b>{{$product->stock}}</b> {{$product->unit}}</h5>
                            <div class="form-group">
                                <label for="stock">Stok</label>
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <input type="number" class="form-control" id="stock" name="stock"
                                            placeholder="Masukkan stok" required>
                                    </div>
                                    <div class="col-6">
                                        {{$product->unit}}
                                    </div>
                                </div>
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

@section('js')
    <script src="{{ asset('js/utils.js') }}"></script>
@stop
