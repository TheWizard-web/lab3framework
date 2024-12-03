@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-8">
        <div class="max-w-8xl mx-auto bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $task->title }}</h1>
            
            <p class="text-gray-600 mb-4">{{ $task->description }}</p>
            
            <p class="text-sm text-gray-500 mb-2">
                <strong>Category:</strong> {{ $task->category->name ?? 'None' }}
            </p>
            
            <p class="text-sm text-gray-500 mb-4">
                <strong>Tags:</strong>
                @foreach ($task->tags as $tag)
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">{{ $tag->name }}</span>
                @endforeach
            </p>
            
            <p class="text-sm text-gray-500">
                <strong>Created at:</strong> {{ $task->created_at->format('d-m-Y H:i') }}
            </p>
            
            <p class="text-sm text-gray-500">
                <strong>Last updated:</strong> {{ $task->updated_at->format('d-m-Y H:i') }}
            </p>
            
            {{-- Edit Button --}}
            <div class="mt-6">
                <a 
                    href="{{ route('tasks.edit', $task->id) }}" 
                    class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 shadow-md transition"
                >
                    Edit Task
                </a>
            </div>
        </div>
    </div>
@endsection
