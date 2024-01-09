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
        <form action="/sales" method="POST">
            @csrf
            <div class="row h-100">
                <div class="col-md-6">
                    <div class="card card-primary h-100">
                        <input type="hidden" name="selected_items" id="selected_items">
                        <input type="hidden" name="grand_total" id="grand_total">
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
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-7">
                                    <h5>Ongkos Kirim</h5>
                                </div>
                                <div class="col-5">
                                    <input type="text" name="shipping_price" id="shipping_price" class="form-control"
                                        placeholder="Ongkir jika ada..." oninput="formatCurrency(this)">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-7">
                                    <h5>Tunai</h5>
                                </div>
                                <div class="col-5">
                                    <input type="text" name="cash" id="cash" class="form-control"
                                        placeholder="Uang tunai..." oninput="formatCurrency(this)" required>
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

                            <button type="button" id="btnPay" class="form-control btn btn-success btn-lg mt-3"
                                style="height: 50px">BAYAR</button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Transaksi Berhasil</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h5>Total Belanja <span class="float-right" id="totalSpendText">10,000</span>
                                            </h5>
                                            <h5>Tunai <span class="float-right" id="cashText">10,000</span></h5>
                                            <h3>Kembalian <b class="float-right" id="changeText">5,000</b></h3>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Tutup</button>
                                            <button type="button" id="print-struk" class="btn btn-primary">Print
                                                Struk</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="spinner-box" id="spinner-box">
                    <div class="pulse-container">
                        <div class="pulse-bubble pulse-bubble-1"></div>
                        <div class="pulse-bubble pulse-bubble-2"></div>
                        <div class="pulse-bubble pulse-bubble-3"></div>
                    </div>
                </div>
            </div>

        </form>
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


        @keyframes pulse {
            from {
                opacity: 1;
                transform: scale(1);
            }

            to {
                opacity: .25;
                transform: scale(.75);
            }
        }

        /* GRID STYLING */

        /* * {
                            box-sizing: border-box;
                        } */

        .spinner-box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 999
        }


        /* PULSE BUBBLES */

        .pulse-container {
            width: 120px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pulse-bubble {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #3ff9dc;
        }

        .pulse-bubble-1 {
            animation: pulse .4s ease 0s infinite alternate;
        }

        .pulse-bubble-2 {
            animation: pulse .4s ease .2s infinite alternate;
        }

        .pulse-bubble-3 {
            animation: pulse .4s ease .4s infinite alternate;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#customer_id').select2();
            $("#searchInput").focus();
            $("#spinner-box").hide();
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
                    var item = $(
                        '<div class="card p-3">\
                                                                            <div class="row">\
                                                                                <div class="col-7">\
                                                                                    <div class="row">\
                                                                                        <h5 style="font-size: 14pt; font-weight: 600;">' +
                        result
                        .name + '</h5>\
                                                                                    </div>\
                                                                                    <div class="row">\
                                                                                        <h6>Rp. ' + Intl.NumberFormat(
                            'en-ID')
                        .format(
                            result
                            .selling_price) +
                        ' / ' + result.unit +
                        '</h6>\
                                                                                    </div>\
                                                                                    <div class="row text-center">\
                                                                                        <button type="button" class="btn btn-secondary mr-3 decrement" data-id="' +
                        result.id + '"><i\
                                                                                                class="fas fa-minus"></i></button>\
                                                                                        <span class="mt-1">' + result.qty +
                        '</span>\
                                                                                        <button type="button" class="btn btn-secondary ml-3 increment" data-id="' +
                        result.id +
                        '"><i\
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
                totalSpend += parseFloat($('#shipping_price').val() == '' ? '0' : $('#shipping_price').val()
                    .replace(/,/g, ''));
                $('#total-spend').text('Rp. ' + Intl.NumberFormat('en-ID').format(totalSpend) + '');
                $('#selected_items').val(JSON.stringify(selectedItem));
                $('#grand_total').val(totalSpend);
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
                if (selectedItem[index].stock < (selectedItem[index].qty + 1)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Stok tidak cukup',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return;
                }
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

            $(document).on("click", "#print-struk", function() {
                $('#exampleModal').modal('hide');

                $.ajax({
                    type: 'POST',
                    url: '/print-struk',
                    data: {
                        _token: '{{ csrf_token() }}',
                        items: selectedItem,
                        cash: (parseFloat($('#cash').val() == '' ? '0' : $('#cash').val()
                            .replace(/,/g, ''))),
                    },
                    success: function(printContent) {
                        var originalContent = document.body.innerHTML;
                        document.body.innerHTML = printContent;
                        window.print();
                        window.location.href = '/home';
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $(document).on("click", "#btnPay", function() {
                if ($('#selected_items').val() == '') {
                    alert('Anda belum memilih produk.');
                    return;
                }
                if ($('#cash').val() == '' || $('#cash').val() == '0') {
                    alert('Uang tunai wajib diisi.');
                    return;
                }
                var cash = parseFloat($('#cash').val() == '' ? '0' : $('#cash').val()
                    .replace(/,/g, ''));
                if (cash < $('#grand_total').val()) {
                    alert('Uang tunai kurang dari total belanja.');
                    return;
                }
                $('#spinner-box').show();
                var data = {
                    cash: cash,
                    customer_id: $('#customer_id').val(),
                    shipping_price: $('#shipping_price').val(),
                    grand_total: $('#grand_total').val(),
                    selected_items: $('#selected_items').val(),
                    _token: '{{ csrf_token() }}',
                };

                $.ajax({
                    type: 'POST',
                    url: '/sales',
                    data: data,
                    success: function(response) {
                        $('#spinner-box').hide();
                        var change = (parseFloat($('#cash').val() == '' ? '0' : $('#cash').val()
                            .replace(/,/g, ''))) - totalSpend;
                        $('#totalSpendText').text($('#total-spend').text());
                        $('#cashText').text('Rp. ' + $('#cash').val() + '');
                        $('#changeText').text('Rp. ' + Intl.NumberFormat('en-ID').format(
                            change) + '');
                        $('#exampleModal').modal('show');
                    },
                    error: function(error) {
                        alert('Transaksi Gagal, ada kesalahan pada sistem');
                    }
                });
            });

            function appendToSelectedItems(selectedItem) {
                $('#scrollable-content').empty();
                for (let index = 0; index < selectedItem.length; index++) {
                    var item = $(
                        '<div class="card p-3">\
                                                                            <div class="row">\
                                                                                <div class="col-7">\
                                                                                    <div class="row">\
                                                                                        <h5 style="font-size: 14pt; font-weight: 600;">' +
                        selectedItem[
                            index]
                        .name + '</h5>\
                                                                                    </div>\
                                                                                    <div class="row">\
                                                                                        <h6>Rp. ' + Intl.NumberFormat(
                            'en-ID')
                        .format(
                            selectedItem[
                                index]
                            .selling_price) +
                        ' / ' + selectedItem[index].unit +
                        '</h6>\
                                                                                    </div>\
                                                                                    <div class="row text-center">\
                                                                                        <button type="button" class="btn btn-secondary mr-3 decrement" data-id="' +
                        selectedItem[index].id + '"><i\
                                                                                                class="fas fa-minus"></i></button>\
                                                                                        <span class="mt-1">' +
                        selectedItem[
                            index]
                        .qty +
                        '</span>\
                                                                                        <button type="button" class="btn btn-secondary ml-3 increment" data-id="' +
                        selectedItem[index].id +
                        '"><i\
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
                        '<span class="result-nominal"> ' + Intl.NumberFormat('en-ID').format(result
                            .selling_price) + '</span>' +
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
    <script src="{{ asset('js/utils.js') }}"></script>
@stop
