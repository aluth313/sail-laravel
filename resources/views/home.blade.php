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
                <div class="col-md-12" style="position: absolute; z-index: 1;">
                    <ul class="list-group mt-2" id="searchResults"></ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-2" style="height: 70vh;">
        <div class="row h-100">
            <div class="col-md-6">
                <div class="card card-primary h-100">
                    <div class="card-body" id="scrollable-content">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-7">
                                <h5>Pelanggan</h5>
                            </div>
                            <div class="col-5">
                                <select name="customer_id" id="customer_id" class="form-control">
                                    <option value="">== Pilih Pelanggan ==</option>
                                    <option value="1">Aceng</option>
                                    <option value="2">Ucok</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-7">
                                <h5>Ongkos Kirim</h5>
                            </div>
                            <div class="col-5">
                                <input type="number" name="shipping_price" id="shipping_price" class="form-control"
                                    placeholder="Ongkir jika ada...">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-7">
                                <h5>Total Belanja</h5>
                            </div>
                            <div class="col-5">
                                <h5 class="text-right text-primary font-weight-bold" id="total-spend">Rp. 0</h5>
                            </div>
                        </div>

                        <button class="form-control btn btn-success btn-lg mt-3" style="height: 50px">BAYAR</button>
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

        #scrollable-content {
            max-height: 70vh;
            /* Sesuaikan dengan tinggi yang diinginkan */
            overflow-y: auto;
        }

        .result-nominal {
            float: right;
            /* Untuk memposisikan elemen ke sebelah kanan */
            color: #007bff;
            /* Warna teks */
            font-weight: bold;
            /* Ketebalan teks */
            /* Tambahkan gaya lain sesuai kebutuhan */
        }

        /* .delete-item {
                text-align-last: right;
            } */
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $("#searchInput").focus();
            var selectedItem = [];
            var totalSpend = 0;
            $("#searchInput").on("input", function() {
                isLanjutanDieksekusi = false;
                setTimeout(() => {
                    if (!isLanjutanDieksekusi) {
                        var inputValue = $(this).val().toLowerCase();
                        if (inputValue.length > 0) {
                            var data = {
                                query: inputValue,
                                _token: '{{ csrf_token() }}',
                            };

                            $.ajax({
                                type: 'POST',
                                url: '/products/search',
                                data: data,
                                success: function(response) {
                                    if (response.length > 0) {
                                        displaySearchResults(response);
                                    } else {
                                        $("#searchResults").append(
                                            '<li class="list-group-item">produk tidak ditemukan</li>'
                                        );
                                    }
                                },
                                error: function(error) {
                                    console.error('Terjadi kesalahan:', error);
                                }
                            });
                        } else {
                            // Kosongkan hasil pencarian jika tidak ada nilai input
                            $("#searchResults").empty();
                        }
                        isLanjutanDieksekusi = true;
                    }
                }, 1000);
            });
            
            $("#shipping_price").on("input", function() {
                calculateTotalSpend();
            });

            // Fungsi untuk menangani klik pada hasil pencarian
            $(document).on("click", ".search-result-item", function() {
                var result = $(this).data('result');
                var isExist = selectedItem.findIndex(item => item.id == result.id);
                if (isExist == -1) {
                    result.qty = 1;
                    selectedItem.push(result);
                    var item = $('<div class="card p-3">\
                                        <div class="row">\
                                            <div class="col-7">\
                                                <div class="row">\
                                                    <h5 style="font-size: 14pt; font-weight: 600;">' + result.name + '</h5>\
                                                </div>\
                                                <div class="row">\
                                                    <h6>Rp. ' + result.selling_price +
                        '</h6>\
                                                </div>\
                                                <div class="row text-center">\
                                                    <button type="button" class="btn btn-secondary mr-3 decrement" data-id="' + result.id + '"><i\
                                                            class="fas fa-minus"></i></button>\
                                                    <span class="mt-1">' + result.qty +
                        '</span>\
                                                    <button type="button" class="btn btn-secondary ml-3 increment" data-id="' + result.id + '"><i\
                                                            class="fas fa-plus"></i></button>\
                                                </div>\
                                            </div>\
                                            <div class="col-5 align-self-center text-right">\
                                                <button type="button" class="btn btn-danger delete-item" data-id="' +
                        result.id + '"><i class="fas fa-trash"></i></button>\
                                            </div>\
                                        </div>\
                                    </div>');

                    $('#scrollable-content').append(item);
                } else {
                    selectedItem[isExist].qty += 1;
                    appendToSelectedItems(selectedItem);
                }

                $("#searchResults").empty();
                $("#searchInput").val('');
                $("#searchInput").focus();
                calculateTotalSpend();
            });

            function calculateTotalSpend() {
                totalSpend = 0;
                for (let index = 0; index < selectedItem.length; index++) {
                    totalSpend += (selectedItem[index].qty * selectedItem[index].selling_price);
                }
                totalSpend += parseFloat($('#shipping_price').val() == '' ? '0' : $('#shipping_price').val());
                $('#total-spend').text('Rp. '+totalSpend+'');
            }

            $(document).on("click", ".delete-item", function() {
                var result = $(this).data('id');
                selectedItem = selectedItem.filter(item => item.id != result);

                appendToSelectedItems(selectedItem)
                $("#searchInput").focus();
                calculateTotalSpend();
            });

            $(document).on("click", ".increment", function() {
                var result = $(this).data('id');
                var index = selectedItem.findIndex(item => item.id == result);
                selectedItem[index].qty += 1;

                appendToSelectedItems(selectedItem)
                $("#searchInput").focus();
                calculateTotalSpend();
            });

            $(document).on("click", ".decrement", function() {
                var result = $(this).data('id');
                var index = selectedItem.findIndex(item => item.id == result);
                if (selectedItem[index].qty > 1) {
                    selectedItem[index].qty -= 1;
                    appendToSelectedItems(selectedItem);
                }
                $("#searchInput").focus();
                calculateTotalSpend();
            });

            function appendToSelectedItems(selectedItem) {
                $('#scrollable-content').empty();
                for (let index = 0; index < selectedItem.length; index++) {
                    var item = $('<div class="card p-3">\
                                        <div class="row">\
                                            <div class="col-7">\
                                                <div class="row">\
                                                    <h5 style="font-size: 14pt; font-weight: 600;">' + selectedItem[index]
                        .name + '</h5>\
                                                </div>\
                                                <div class="row">\
                                                    <h6>Rp. ' + selectedItem[index].selling_price +
                        '</h6>\
                                                </div>\
                                                <div class="row text-center">\
                                                    <button type="button" class="btn btn-secondary mr-3 decrement" data-id="' + selectedItem[index].id + '"><i\
                                                            class="fas fa-minus"></i></button>\
                                                    <span class="mt-1">' + selectedItem[index].qty +
                        '</span>\
                                                    <button type="button" class="btn btn-secondary ml-3 increment" data-id="' + selectedItem[index].id + '"><i\
                                                            class="fas fa-plus"></i></button>\
                                                </div>\
                                            </div>\
                                            <div class="col-5 align-self-center text-right">\
                                                <button type="button" class="btn btn-danger delete-item" data-id="' +
                        selectedItem[index].id + '"><i class="fas fa-trash"></i></button>\
                                            </div>\
                                        </div>\
                                    </div>');

                    $('#scrollable-content').append(item);
                }
            }

            // Fungsi untuk menampilkan hasil pencarian dalam daftar
            function displaySearchResults(results) {
                // Kosongkan daftar hasil pencarian sebelum menambahkan hasil baru
                $("#searchResults").empty();

                // Tambahkan setiap hasil pencarian ke dalam daftar
                results.forEach(function(result) {
                    var liElement = $('<li class="list-group-item search-result-item" data-result>' + result
                        .name +
                        '<span class="result-nominal"> ' + result.selling_price + '</span>' +
                        '</li>');

                    // $("#searchResults").append('<li class="list-group-item search-result-item">' + result.name +
                    //     '<span class="result-nominal"> '+ result.selling_price +'</span>' +
                    //     '</li>');
                    liElement.attr('data-result', JSON.stringify(result));
                    $("#searchResults").append(liElement);
                });
            }
        });
    </script>
@stop
