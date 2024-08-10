@extends('layouts.admin')

@section('title', 'Update ' . $client->name)

@section('content')
    <h3>Updating Client <span class="underline">{{ $client->name }}</span></h3>
    <form action="{{ route('clients.update', ['client' => $client->id]) }}" method="post">
        @csrf
        <label for="name">Name:</label>
        <input id="name" name="name" type="text" value="{{ old('name', $client->name) }}" />
        <br>
        <label for="lastname">Last Name:</label>
        <input id="lastname" name="lastname" type="text" value="{{ old('lastname', $client->lastname) }}" />
        <br>
        <label for="email">Email:</label>
        <input id="email" name="email" type="email" value="{{ old('email', $client->email) }}" />
        <br>
        <label for="phone">Phone:</label>
        <input id="phone" name="phone" type="text" value="{{ old('phone', $client->phone) }}" />
        <br>
        <label for="birthdate">Birthdate:</label>
        <input id="birthdate" name="birthdate" type="date" value="{{ old('birthdate', date('Y-m-d', strtotime($client->birthdate))) }}" />
        <br>
        <input class="submit-btn" type="submit" value="UPDATE">
    </form>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    <x-alert type="error" :message="$error" />
                </li>
            @endforeach
        </ul>
    @endif
@endsection
