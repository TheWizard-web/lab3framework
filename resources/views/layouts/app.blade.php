<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>@yield('title', 'Default Title')</title>
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">
    <!-- Meniul de navigare -->
    <nav class="bg-white shadow-md p-4">
        <ul class="flex justify-center space-x-8">
            <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }} hover:text-blue-600 font-semibold text-gray-700">Acasă</a></li>
            <li><a href="{{ url('/tasks') }}" class="{{ request()->is('tasks') ? 'active' : '' }} hover:text-blue-600 font-semibold text-gray-700">Sarcini</a></li>
            <li><a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }} hover:text-blue-600 font-semibold text-gray-700">Despre noi</a></li>
        </ul>
    </nav>

    <!-- Antet -->
    <!-- <x-header class="text-center bg-gradient-to-r from-blue-500 to-teal-500 text-white py-8 text-4xl font-bold shadow-md">
        @yield('title')
    </x-header> -->

    <!-- Conținutul paginii -->
    <div class="content w-8xl mx-auto p-8 bg-white shadow-lg rounded-lg mt-8 flex-grow">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="max-w-4xl mx-auto text-center">
            <p>&copy; 2024 ToDoApp. Toate drepturile rezervate.</p>
            <p class="text-gray-400">Creat cu <span class="text-red-500">&hearts;</span> de echipa noastră</p>
        </div>
    </footer>

    <!-- Optional JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>




