@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <form method="post" action="{{ route('login') }}">
        @csrf
        Email: <input name="email" type="email" required value="{{ old('email') }}">
        <br>
        Password: <input name="password" type="password" required>
        <br>
        <input type="submit" value="Sign in">
    </form>
    @error('email', 'password')
        <x-alert type="error" :message="$message" />
    @enderror
@endsection
