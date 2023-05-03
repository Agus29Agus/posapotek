<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Income Report</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <h3 class="text-center">Income Report</h3>
    <h4 class="text-center">
        Date {{ indonesian_date($begin, false) }}
        until
        Date {{ indonesian_date($end, false) }}
    </h4>

    <table class="table table-striped">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Date</th>
                <th>Sell</th>
                <th>Purchase</th>
                <th>Spending</th>
                <th>Income</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $col)
                        <td>{{ $col }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>