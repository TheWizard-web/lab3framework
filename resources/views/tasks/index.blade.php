@extends('layouts.app')

@section('title', 'Lista de sarcini')

@section('content')
    <div class="py-12">
        <!-- <h1 class="text-4xl font-bold text-gray-800 mb-6 text-center">Lista de sarcini</h1> -->

        <ul class="space-y-4 max-w-2xl mx-auto">
            @foreach($tasks as $task)
                <li class="bg-white shadow-lg p-4 rounded-lg hover:bg-blue-50 transition duration-200">
                    <h3 class="text-lg font-semibold text-blue-600 hover:text-blue-800">
                        <a href="{{ route('tasks.show', $task->id) }}">
                            {{ $task->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600">{{ $task->description }}</p>

                    <p class="text-sm text-gray-500">
                        <strong>Category:</strong> {{ $task->category->name ?? 'None' }}
                    </p>

                    <p class="text-sm text-gray-500">
                        <strong>Tags:</strong>
                        @foreach ($task->tags as $tag)
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">{{ $tag->name }}</span>
                        @endforeach
                    </p>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
