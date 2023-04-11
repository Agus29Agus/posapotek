<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Member Card</title>

    <style>
.box {
  position: relative;
  width: 300px;
  height: 200px;
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  text-align: center;
  padding: 20px;
  margin: 20px auto;
}

.box::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('{{ public_path($setting->path_card_member) }}');
  background-size: cover;
  filter: blur(500px);
  z-index: -1;
}

.box img {
  width: 50%;
  display: block;
  margin: 0 auto;
}

.logo {
  position: absolute;
  top: 10px;
  left: 10px;
}

.logo p {
  font-size: 16px;
  margin: 0;
  font-weight: bold;
}

.logo img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
  margin-top: 10px;
}

.name {
  font-size: 24px;
  margin-top: 160px;
}

.phone {
  font-size: 16px;
  margin-top: 10px;
}

.barcode {
  position: absolute;
  bottom: 10px;
  left: 10px;
  text-align: left;
}

.barcode img {
  width: 40px;
  height: 40px;
  margin-top: 10px;
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
    <section style="border: 1% solid #fff">
        <table width="100%">
            @foreach ($datamember as $key => $data)
                <tr>
                    @foreach ($data as $item)
                        <td class="text-center">
                            <div class="box">
                                <div class="logo">
                                    <p>{{ $setting->name_company }}</p>
                                    {{-- <p>{{ config('app.name') }}</p> --}}
                                    <img src="{{ public_path($setting->path_logo) }}" alt="logo">
                                </div>
                                <div class="name">{{ $item->name }}</div>
                                <div class="phone">{{ $item->phone }}</div>
                                <div class="barcode text-left">
                                    <img src="data:image/png;base64, {{ DNS2D::getBarcodePNG("$item->name", 'QRCODE') }}" alt="qrcode"
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