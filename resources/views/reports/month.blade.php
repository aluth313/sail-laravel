@extends('adminlte::page')

@section('title', 'Laporan Per Bulan')

@section('content_header')
    <h1>Laporan Per Bulan</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <select name="from_date" id="from_date" class="form-control">
                                    <option value="">== Filter Dari ==</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <select name="to_date" id="to_date" class="form-control">
                                    <option value="">== Filter Sampai ==</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-info" id="btn-filter">Filter</button>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12">
                                <table id="datatable" class="display w-100">
                                    <thead>
                                        <tr>
                                            <th>Bulan</th>
                                            <th>Penjualan</th>
                                            <th>Keuntungan</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
@stop

@section('js')
    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
    {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script> --}}
    
    
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            let dateFrom = $('#from_date').val();
            let dateTo = $('#to_date').val();
            let tableData = $('#datatable').DataTable({
                processing: true,
                searching: false,
                serverSide: true,
                order: [0, 'desc'],
                dom: 'Bfrtip',
                buttons: [
                    'excel','pdf','print'
                ],
                scrollX: true,
                ajax: {
                    url: '{{ url('/report-per-month') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        dateFrom: dateFrom,
                        dateTo: dateTo,
                    }
                },
                columns: [{
                        data: 'month',
                        name: 'month'
                    },
                    {
                        data: 'sale',
                        name: 'sale'
                    },
                    {
                        data: 'profit',
                        name: 'profit'
                    },
                ],
            });

            $('#btn-filter').on('click', function() {
                let dateFrom = $('#from_date').val();
                let dateTo = $('#to_date').val();
                if (dateFrom == '' || dateTo == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Pilih rentang bulan terlebih dahulu',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return;
                }
                if (dateFrom > dateTo) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Harap pilih rentang bulan yang benar',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return;
                }
                tableData.destroy();

                tableData = $('#datatable').DataTable({
                    processing: true,
                    searching: false,
                    serverSide: true,
                    dom: 'Bfrtip',
                    buttons: [
                        'excel','pdf','print'
                    ],
                    scrollX: true,
                    order: [0, 'desc'],
                    ajax: {
                        url: '{{ url('/report-per-month') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            dateFrom: dateFrom,
                            dateTo: dateTo,
                        },
                        // success: function(data) {
                        //     console.log(data);
                        // },
                    },
                    columns: [{
                            data: 'month',
                            name: 'month'
                        },
                        {
                            data: 'sale',
                            name: 'sale'
                        },
                        {
                            data: 'profit',
                            name: 'profit'
                        },
                    ],
                });
            });

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

@stop
