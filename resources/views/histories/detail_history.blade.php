@extends('adminlte::page')

@section('title', 'Riwayat Belanja')

@section('content_header')
    <h1>Detail Riwayat Belanja</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">Nama Pelanggan</div>
                            <div class="col-md-3">: {{ $details->customer->name ?? '-' }}</div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2">Tanggal Transaksi</div>
                            <div class="col-md-3">: {{ formatDate($details->created_at, 'j F Y') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-3"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2">Waktu Transaksi</div>
                            <div class="col-md-3">: {{ formatDate($details->created_at, 'H:i') }}</div>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details->salesDetail as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->qty }} {{ $item->unit }}</td>
                                        <td>{{ number_format($item->total, 0, '.', ',') }}</td>
                                    </tr>
                                @endforeach
                                @if ($details->shipping_price)
                                    <tr class="table-secondary">
                                        <th scope="col" colspan="2">Ongkos Kirim</th>
                                        <th scope="col">{{ number_format($details->shipping_price, 0, '.', ',') }}</th>
                                    </tr>
                                @endif
                                <tr class="table-secondary">
                                    <th scope="col" colspan="2">Grand Total</th>
                                    <th scope="col">{{ number_format($details->grand_total, 0, '.', ',') }}</th>
                                </tr>
                                <tr class="table-secondary">
                                    <th scope="col" colspan="2">Tunai</th>
                                    <th scope="col">{{ number_format($details->cash, 0, '.', ',') }}</th>
                                </tr>
                            </tbody>
                            <input type="hidden" id="details" value="{{ json_encode($details) }}">
                        </table>
                        <button class="btn btn-info float-right mt-3" type="button" id="print-struk"><i
                                class="fas fa-print"></i> Cetak Struk</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on("click", "#print-struk", function() {
              var items = [];
              var salesDetail = {{ Js::from($details->salesDetail) }};
              salesDetail.forEach(item => {
                items.push({
                  name: item.product.name,
                  selling_price: item.product.selling_price,
                  unit: item.product.unit,
                  qty: item.qty,
                });
              });
                $.ajax({
                    type: 'POST',
                    url: '/print-struk',
                    data: {
                        _token: '{{ csrf_token() }}',
                        items: items,
                        last_trans: {{ Js::from($details) }},
                        time: {{ Js::from(date('d-m-Y H:i', $details->createdAt)) }},
                        cash: {{ Js::from($details->cash) }},
                        shipping_price: {{ Js::from($details->shipping_price == null ? 0 : $details->shipping_price) }},
                    },
                    success: function(printContent) {
                        var originalContent = document.body.innerHTML;
                        document.body.innerHTML = printContent;
                        window.print();
                        window.location.href = window.location.pathname;
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@stop
