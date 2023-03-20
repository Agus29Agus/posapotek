<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Big</title>

    <style>
        table td {
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 14px;
        }
        table.data td,
        table.data th {
            border: 1px solid #ccc;
            padding: 5px;
        }
        table.data {
            border-collapse: collapse;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <table width="100%">
        <tr>
            <td rowspan="4" width="60%">
                <img src="{{ public_path($setting->path_logo) }}" alt="{{ $setting->path_logo }}" width="120">
                <br>
                {{ $setting->address }}
                <br>
                <br>
            </td>
            <td>Date</td>
            <td>: {{ indonesian_date(date('Y-m-d')) }}</td>
        </tr>
        <tr>
            <td>Member Name</td>
            <td>: {{ $sell->member->name ?? '' }}</td>
        </tr>
    </table>

    <table class="data" width="100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Price/Item</th>
                <th>Total</th>
                <th>Discount</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $key => $item)
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td class="text-center">{{ $item->product->code_product }}</td>
                    <td class="text-center">{{ $item->product->name_product }}</td>
                    <td class="text-center">{{ money_format($item->sell_price) }}</td>
                    <td class="text-center">{{ money_format($item->total) }}</td>
                    <td class="text-center">{{ $item->discount }}</td>
                    <td class="text-right">{{ money_format($item->subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right"><b>Total Price</b></td>
                <td class="text-right"><b>{{ money_format($sell->total_price) }}</b></td>
            </tr>
            <tr>
                <td colspan="6" class="text-right"><b>Discount</b></td>
                <td class="text-right"><b>{{ money_format($sell->discount) }}</b></td>
            </tr>
            <tr>
                <td colspan="6" class="text-right"><b>Total Payments</b></td>
                <td class="text-right"><b>{{ money_format($sell->pay) }}</b></td>
            </tr>
            <tr>
                <td colspan="6" class="text-right"><b>Received</b></td>
                <td class="text-right"><b>{{ money_format($sell->receive) }}</b></td>
            </tr>
            <tr>
                <td colspan="6" class="text-right"><b>Change</b></td>
                <td class="text-right"><b>{{ money_format($sell->receive - $sell->pay) }}</b></td>
            </tr>
        </tfoot>
    </table>

    <table width="100%">
        <tr>
            <td><b>Thank you for your purchase... Get Well Soon</b></td>
            <td class="text-center">
                Cashier
                <br>
                <br>
                {{ auth()->user()->name }}
            </td>
        </tr>
    </table>
</body>
</html>