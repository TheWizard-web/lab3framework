@props([
    'id',
    'title',
    'description',
    'createdAt',
    'updatedAt',
    'status',
    'priority',
    'assignedTo'
])

<div class="task p-6 bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 mb-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $title }}</h2>
    <p class="text-gray-700 mb-4">{{ $description }}</p>

    <div class="text-sm text-gray-500 space-y-1 mb-4">
        <p><strong>Data creării:</strong> {{ $createdAt }}</p>
        <p><strong>Ultima actualizare:</strong> {{ $updatedAt }}</p>
        <p><strong>Stare:</strong> {{ $status ? 'Finalizată' : 'Nu este finalizată' }}</p>
        <p><strong>Prioritate:</strong> {{ ucfirst($priority) }}</p>
        <p><strong>Responsabil:</strong> {{ $assignedTo }}</p>
    </div>

    <div class="actions flex space-x-4">
        <a href="{{ route('tasks.edit', $id) }}" class="text-blue-600 font-semibold hover:underline hover:text-blue-800">
            Editare
        </a>
        <a href="{{ route('tasks.destroy', $id) }}" class="text-red-600 font-semibold hover:underline hover:text-red-800">
            Ștergere
        </a>
    </div>
</div>

