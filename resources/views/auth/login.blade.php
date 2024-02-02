<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <form method="post" action="/auth">
        @csrf
        Email: <input name="email" type="text" required value="{{ old('email') }}">
        <br>
        Password: <input name="password"  type="password" required>
        <br>
        <input type="submit" value="Sign in">
    </form>
    @error('email')
        <p style="color:#ff0000;">The provided credentials do not match our records.</p>
    @enderror
</body>
</html>