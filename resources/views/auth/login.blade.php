@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <form method="post" action="/login">
        @csrf
        Email: <input name="email" type="email" required value="{{ old('email') }}">
        <br>
        Password: <input name="password" type="password" required>
        <br>
        <input type="submit" value="Sign in">
    </form>
    @error('email', 'password')
        <div class="danger">{{ $message }}</div>
    @enderror
@endsection
