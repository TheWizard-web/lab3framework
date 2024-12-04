@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-8">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label for="name">Nume:</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="password">Parolă:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirmă parola:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>
        <button type="submit">Înregistrează-te</button>
    </form>
</div>
@endsection
