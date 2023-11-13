@extends('adminlte::page')

@section('title', 'Penjualan')

@section('content_header')
    <h1>Penjualan</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari produk.." aria-label="Cari..."
                        aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i
                                class="fas fa-search"></i></button>
                    </div>
                </div>
                <ul class="list-group mt-3" id="searchResults"></ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <h1>Hai</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Tambahkan gaya untuk efek hover */
        .search-result-item:hover {
            cursor: pointer;
            background-color: #f8f9fa;
        }

        /* Tambahkan gaya untuk ketinggian maksimal pada daftar hasil pencarian */
        #searchResults {
            max-height: 200px;
            /* Sesuaikan dengan tinggi yang diinginkan */
            overflow-y: auto;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $("#searchInput").on("input", function() {
                // Dapatkan nilai input
                var inputValue = $(this).val().toLowerCase();

                // Hanya tampilkan hasil pencarian jika ada nilai input
                if (inputValue.length > 0) {
                    // Simulasikan hasil pencarian (gantilah dengan logika pencarian sesungguhnya)
                    var searchResults = ["Item 1", "Item 2", "Item 3", "Item 4", "Item 5", "Item 6"];

                    // Tampilkan hasil pencarian dalam daftar
                    displaySearchResults(searchResults);
                } else {
                    // Kosongkan hasil pencarian jika tidak ada nilai input
                    $("#searchResults").empty();
                }
            });

            // Fungsi untuk menangani klik pada hasil pencarian
            $(document).on("click", ".search-result-item", function() {
                // Tangkap teks dari item yang diklik
                var selectedItemText = $(this).text();

                // Tampilkan teks item yang diklik di console (gantilah dengan aksi yang sesuai)
                console.log("Anda memilih: " + selectedItemText);
                $("#searchResults").empty();
                $("#searchInput").val('');
            });

            // Fungsi untuk menampilkan hasil pencarian dalam daftar
            function displaySearchResults(results) {
                // Kosongkan daftar hasil pencarian sebelum menambahkan hasil baru
                $("#searchResults").empty();

                // Tambahkan setiap hasil pencarian ke dalam daftar
                results.forEach(function(result) {
                    $("#searchResults").append('<li class="list-group-item search-result-item">' + result +
                        '</li>');
                });
            }
        });
    </script>
@stop
