@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-8">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="password">Parolă:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Autentifică-te</button>
    </form>
</div>
@endsection
