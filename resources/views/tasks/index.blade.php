@extends('layouts.app')

@section('title', 'Lista de sarcini')

@section('content')
    <div class="py-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-6 text-center">Lista de sarcini</h1>

        <ul class="space-y-4 max-w-2xl mx-auto">
            @foreach($tasks as $task)
                <li class="bg-white shadow-lg p-4 rounded-lg hover:bg-blue-50 transition duration-200">
                    <a href="{{ route('tasks.show', $task['id']) }}" class="text-lg font-semibold text-blue-600 hover:text-blue-800">
                        {{ $task['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

