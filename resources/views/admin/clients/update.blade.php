@extends('layouts.admin')

@section('title', 'Update ' . $client->name)

@section('content')
    <h3>Updating client <span class="underline">{{ $client->name }}</span></h3>
    <form action="{{ route('clients.update', ['client' => $client]) }}" method="post">
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
        <input id="birthdate" name="birthdate" type="date"
            value="{{ old('birthdate', date('Y-m-d', strtotime($client->birthdate))) }}" />
        <fieldset>
            <legend>Select a method to send confirmation code:</legend>
            <label for="sms">SMS</label>
            <input type="radio" id="sms" name="method" value="sms" checked />
            <br>
            <label for="email">Email</label>
            <input type="radio" id="email" name="method" value="email" />
            <br>
            <label for="telegram">Telegram</label>
            <input type="radio" id="telegram" name="method" value="telegram" />
        </fieldset>
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
