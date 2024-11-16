@extends('layouts.app')

@section('title', 'Creare Sarcină')

@section('content')
    <h1>Crează o sarcină nouă</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        {{-- Titlu --}}
        <div>
            <label for="title">Titlu</label>
            <input type="text" name="title" id="title" required>
        </div>

        {{-- Descriere --}}
        <div>
            <label for="description">Descriere</label>
            <textarea name="description" id="description" required></textarea>
        </div>

        {{-- Categorie --}}
        <div>
            <label for="category_id">Categorie</label>
            <select name="category_id" id="category_id" required>
                <option value="">-- Selectează o categorie --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Etichete --}}
        <div>
            <label for="tags">Etichete</label>
            <select name="tags[]" id="tags" multiple>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Submit --}}
        <button type="submit">Crează Sarcina</button>
    </form>
@endsection
