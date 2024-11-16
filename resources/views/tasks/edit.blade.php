@extends('layouts.app')

@section('title', 'Editare Sarcină')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Editare Sarcină</h1>

        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            {{-- Titlu --}}
            <div class="mb-4">
                <label for="title" class="block text-lg font-medium text-gray-700">Titlu</label>
                <input type="text" name="title" id="title" value="{{ $task->title }}" required 
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            {{-- Descriere --}}
            <div class="mb-4">
                <label for="description" class="block text-lg font-medium text-gray-700">Descriere</label>
                <textarea name="description" id="description" required 
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $task->description }}</textarea>
            </div>

            {{-- Categorie --}}
            <div class="mb-4">
                <label for="category_id" class="block text-lg font-medium text-gray-700">Categorie</label>
                <select name="category_id" id="category_id" required 
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $task->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Etichete --}}
            <div class="mb-4">
                <label for="tags" class="block text-lg font-medium text-gray-700">Etichete</label>
                <select name="tags[]" id="tags" multiple 
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, $task->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Submit --}}
            <div class="mb-4">
                <button type="submit" 
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Actualizează Sarcina
                </button>
            </div>
        </form>
    </div>
@endsection
