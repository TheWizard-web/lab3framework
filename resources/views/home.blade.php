@extends('layouts.app')

<!-- @section('title', 'Pagina Principală') -->

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-2">Bun venit la To-Do App</h1>
        <p class="mb-4">To-Do App pentru echipe.</p>

        <nav class="mb-4">
            <ul class="flex space-x-4">
                <li><a href="{{ route('tasks.index') }}" class="text-blue-500 hover:underline">Lista de sarcini</a></li>
                <li><a href="{{ route('tasks.create') }}" class="text-blue-500 hover:underline">Crearea unei sarcini</a></li>
            </ul>
        </nav>

        <p class="mb-4">Această aplicație vă ajută să gestionați sarcinile cu ușurință.</p>
    </div>
@endsection
