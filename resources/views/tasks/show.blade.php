@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($tasks as $task)
                <x-task 
                    title="{{ $task['title'] }}" 
                    description="{{ $task['description'] }}"
                    createdAt="{{ $task['created_at'] }}"
                    updatedAt="{{ $task['updated_at'] }}"
                    status="{{ $task['status'] }}"
                    priority="{{ $task['priority'] }}"
                    assignedTo="{{ $task['assigned_to'] }}"
                    id="{{ $task['id'] }}"
                />
            @endforeach
        </div>
    </div>
@endsection


