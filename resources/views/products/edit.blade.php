@extends('adminlte::page')

@section('title', 'Produk')

@section('content_header')
    <h1>Ubah Produk</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Ubah Produk</h3>
                    </div>


                    <form method="POST" action="/products/{{$product->id}}">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nama Produk</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama produk" value="{{$product->name}}" required>
                            </div>
                            <div class="form-group">
                                <label for="stock">Stok</label>
                                <input type="number" class="form-control" id="stock" name="stock" placeholder="Masukkan stok" value="{{$product->stock}}" required>
                            </div>
                            <div class="form-group">
                                <label for="unit">Satuan</label>
                                <input type="text" class="form-control" id="unit" name="unit" placeholder="Masukkan Satuan" value="{{$product->unit}}">
                            </div>
                            <div class="form-group">
                                <label for="purchase_price">Harga Beli</label>
                                <input type="number" class="form-control" id="purchase_price" name="purchase_price"
                                    placeholder="Masukkan Harga Beli atau Modal" value="{{$product->purchase_price}}" required>
                            </div>
                            <div class="form-group">
                                <label for="selling_price">Harga Jual</label>
                                <input type="number" class="form-control" id="selling_price" name="selling_price"
                                    placeholder="Masukkan Harga Jual atau Modal" value="{{$product->selling_price}}" required>
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

@section('css')
@stop
