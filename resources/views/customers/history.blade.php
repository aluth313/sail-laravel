@extends('adminlte::page')

@section('title', 'Riwayat Belanja')

@section('content_header')
    <h1>Riwayat Belanja {{ $customer->name }}</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <table id="datatable" claa="display" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Waktu</th>
                                    <th>Jumlah Produk</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
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

    <script type="text/javascript">
        $(document).ready(function() {
            var cust_id = {{ $id }};
            $('#datatable').DataTable({
                processing: true,
                severSide: true,
                scrollX: true,
                ajax: '{{ url("/customers/history/") }}/' + cust_id,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'grand_total',
                        name: 'grand_total'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            $('#datatable').on('click', '.delete', function() {
                let form = "{{ url('customers') }}/" + $(this).data('id');
                $('#formModal').attr('action', form);
                $('#btnModal').modal('show');
            });

        })
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