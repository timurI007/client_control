<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Client Control')</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="container">
        <div>
            @yield('content')
        </div>
    </div>
</body>
</html>