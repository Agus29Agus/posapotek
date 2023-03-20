<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Member Card</title>

    <style>
        .box {
            position: flex;
        }
        .card {
            width:140mm;
        }
        .logo {
            position: flex;
            top: 3pt;
            right: 0pt;
            font-size: 16pt;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            color: #090000 !important;
        }
        .logo p {
            text-align: right;
            margin-right: 16pt;
        }
        .logo img {
            position: flex;
            margin-top: -5pt;
            width: 40px;
            height: 40px;
            right: 16pt;
        }
        .name {
            position: flex;
            top: 100pt;
            right: 16pt;
            font-size: 12pt;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            color: #090000 !important;
        }
        .phone {
            position: flex;
            margin-top: 120pt;
            right: 16pt;
            color: #090000;
        }
        .barcode {
            position: flex;
            top: 50pt;
            left: .860rem;
            border: 1px solid #090000;
            padding: .5px;
            background: #fff;
        }
        .text-left {
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <section style="border: 1px solid #fff">
        <table width="100%">
            @foreach ($datamember as $key => $data)
                <tr>
                    @foreach ($data as $item)
                        <td class="text-center">
                            <div class="box">
                                <img src="{{ public_path($setting->path_card_member) }}" alt="card" width="50%">
                                <div class="logo">
                                    <p>{{ $setting->name_company }}</p>
                                    {{-- <p>{{ config('app.name') }}</p> --}}
                                    <img src="{{ public_path($setting->path_logo) }}" alt="logo">
                                </div>
                                <div class="name">{{ $item->name }}</div>
                                <div class="phone">{{ $item->phone }}</div>
                                <div class="barcode text-left">
                                    <img src="data:image/png;base64, {{ DNS2D::getBarcodePNG("$item->code_member", 'QRCODE') }}" alt="qrcode"
                                        height="40"
                                        widht="40">
                                </div>
                            </div>
                        </td>
                        
                        @if (count($datamember) == 1)
                        <td class="text-center" style="width: 50%;"></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>
    </section>
</body>
</html>