@extends('layouts.app')

@section('title', 'Creare Sarcină')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Crează o sarcină nouă</h1>

        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Titlu --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titlu</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    required 
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                >
            </div>

            {{-- Descriere --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descriere</label>
                <textarea 
                    name="description" 
                    id="description" 
                    required 
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                    rows="4"
                ></textarea>
            </div>

            {{-- Categorie --}}
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categorie</label>
                <select 
                    name="category_id" 
                    id="category_id" 
                    required 
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                >
                    <option value="">-- Selectează o categorie --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Etichete --}}
            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Etichete</label>
                <select 
                    name="tags[]" 
                    id="tags" 
                    multiple 
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                >
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-1">Poți selecta mai multe etichete folosind Ctrl (sau Cmd pe Mac).</p>
            </div>

            {{-- Submit --}}
            <div>
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow hover:bg-blue-700 focus:ring-4 focus:ring-blue-500"
                >
                    Crează Sarcina
                </button>
            </div>
        </form>
    </div>
@endsection
