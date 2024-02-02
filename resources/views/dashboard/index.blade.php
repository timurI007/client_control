<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <style>
        table{
            margin-top: 10px;
        }
        table, th, td {
          border: 1px solid;
        }
        th, td{
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    @include('app.header')
    <h3>OUR CLIENTS:</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>Date Of Birth</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td><a href="/client/{{ $client->id }}">link {{ $client->id }}</a></td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->lastname }}</td>
                    <td>{{ date_create($client->birthdate)->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>