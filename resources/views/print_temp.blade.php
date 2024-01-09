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
        <p class="centered">Toko Lilis
            <br>Majalaya
            {{-- <br>Address line 2 --}}
        </p>
        <table>
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
                <tr class="bordered-top">
                    <td class="quantity align-content-top"></td>
                    <td class="description bold align-content-top">Total</td>
                    <td class="price bold align-content-top">Rp. {{ number_format(calculateTotal($items), 0, '.', ',') }}</td>
                </tr>
                <tr>
                    <td class="quantity align-content-top"></td>
                    <td class="description bold align-content-top">Tunai</td>
                    <td class="price bold align-content-top">Rp. {{ number_format($cash, 0, '.', ',') }}</td>
                </tr>
                <tr>
                    <td class="quantity align-content-top"></td>
                    <td class="description bold align-content-top">Kembalian</td>
                    <td class="price bold align-content-top">Rp. {{ number_format($cash - calculateTotal($items), 0, '.', ',') }}</td>
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
