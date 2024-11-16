@extends('layouts.app')

@section('title', 'Editare Sarcină')

@section('content')
    <h1>Editare Sarcină</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Titlu --}}
        <div>
            <label for="title">Titlu</label>
            <input type="text" name="title" id="title" value="{{ $task->title }}" required>
        </div>

        {{-- Descriere --}}
        <div>
            <label for="description">Descriere</label>
            <textarea name="description" id="description" required>{{ $task->description }}</textarea>
        </div>

        {{-- Categorie --}}
        <div>
            <label for="category_id">Categorie</label>
            <select name="category_id" id="category_id" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $task->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Etichete --}}
        <div>
            <label for="tags">Etichete</label>
            <select name="tags[]" id="tags" multiple>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" {{ in_array($tag->id, $task->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Submit --}}
        <button type="submit">Actualizează Sarcina</button>
    </form>
@endsection
