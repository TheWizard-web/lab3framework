<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = [
            ['id' => 1, 'title' => 'Cumpărături'],
            ['id' => 2, 'title' => 'Spălat mașina'],
            ['id' => 3, 'title' => 'Finalizat proiect'],
        ];
    
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function create()
    {
        return 'Afișează formularul pentru crearea unei sarcini';
    }

    public function store(Request $request)
    {
        // mai târziu
    }

    public function show($id)
    {
        $task = [
            'id' => $id,
            'title' => 'Titlul sarcinii',
            'description' => 'Aceasta este descrierea detaliată a sarcinii.',
            'created_at' => now()->subDays(2)->format('d-m-Y'),
            'updated_at' => now()->format('d-m-Y'),
            'status' => false, // sarcina nu este finalizată
            'priority' => 'medie',
            'assigned_to' => 'John Doe'
        ];
    
        return view('tasks.show', ['task' => $task]);
    }

    public function edit($id)
    {
        return "Afișează formularul pentru editarea sarcinii cu ID-ul: $id";
    }

    public function update(Request $request, $id)
    {
        // mai târziu
    }

    public function destroy($id)
    {
        // mai târziu
    }
}
