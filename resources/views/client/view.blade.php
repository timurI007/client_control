<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Client View</title>
</head>
<body>
    @include('app.header', ['dashboard' => true])
    <h3>Client's data:</h3>
    <div style="display:flex;gap:15px;">
        <div>
            <p>ID</p>
            <p>Name</p>
            <p>Last Name</p>
            <p>Email</p>
            <p>Phone</p>
            <p>Date Of Birth</p>
        </div>
        <div>
            <p>{{ $client->id }}</p>
            <p>{{ $client->name }}</p>
            <p>{{ $client->lastname }}</p>
            <p>{{ $client->email }}</p>
            <p>{{ $client->phone }}</p>
            <p>{{ date_create($client->birthdate)->format('Y-m-d') }}</p>
        </div>
    </div>
    <a href="/client/{{ $client->id }}/edit">EDIT CLIENT</a>
</body>
</html>