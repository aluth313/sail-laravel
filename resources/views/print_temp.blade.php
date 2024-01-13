<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        * {
            font-size: 12px;
            font-family: 'Times New Roman';
        }

        .bordered-bottom {
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }
        
        .bordered-top {
            border-top: 1px solid black;
            border-collapse: collapse;
        }

        td.description,
        th.description {
            width: 75px;
            max-width: 75px;
        }

        td.quantity,
        th.quantity {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }

        td.price,
        th.price {
            width: 100px;
            max-width: 100px;
            word-break: break-all;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: 155px;
            max-width: 155px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        .align-content-top {
            vertical-align: top;
        }
        
        .bold {
            font-weight: bold;
        }

        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }
    </style>
    <title>Toko Lilis</title>
</head>

<body>
    <div class="ticket">
        {{-- <img src="{{ asset('') }}" alt="Logo"> --}}
        <p class="centered">Jayadi Collections
            <br>Panyadap Majalaya
            <br>082320744773
        </p>
        <span>No. <span style="float: right;">{{ $invoice }}</span></span><br>
        <span>Pembeli <span style="float: right;">{{ $customer != null ? str_pad($customer->id, 4, '0', STR_PAD_LEFT).' '.$customer->name : '-' }} </span></span><br>
        <span>Tanggal <span style="float: right;">{{ formatDate($time, 'd-m-Y H:i') }}</span></span>
        <table style="margin-top: 10px">
            <thead>
                <tr class="bordered-top bordered-bottom">
                    <th class="quantity">Jml</th>
                    <th class="description">Item</th>
                    <th class="price">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td class="quantity align-content-top">{{ $item['qty'] }}</td>
                    <td class="description align-content-top">{{ $item['name'] }}</td>
                    <td class="price align-content-top">Rp. {{ number_format($item['selling_price'], 0, '.', ',') }}</td>
                </tr>
                @endforeach
                @if($shipping_price > 0)
                <tr class="bordered-top">
                    <td colspan="3" class="bold">
                        <span>Ongkir <span style="float: right">Rp. {{ number_format($shipping_price, 0, '.', ',') }}</span></span>
                    </td>
                </tr>
                @endif
                <tr class="{{ $shipping_price > 0 ? '' : 'bordered-top' }}">
                    <td colspan="3" class="bold">
                        <span>Total <span style="float: right">Rp. {{ number_format(calculateTotal($items, $shipping_price), 0, '.', ',') }}</span></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="bold">
                        <span>Tunai <span style="float: right">Rp. {{ number_format($cash, 0, '.', ',') }}</span></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="bold">
                        <span>Kembalian <span style="float: right">Rp. {{ number_format($cash - calculateTotal($items, $shipping_price), 0, '.', ',') }}</span></span>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <br>
        <p class="centered">Terimakasih sudah belanja
            <br>Sehat selalu
        </p>
    </div>
</body>

</html>
