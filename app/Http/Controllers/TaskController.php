<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // 1. Metoda index: Obține lista de sarcini cu relațiile lor asociate
    public function index()
    {
          // Folosește Eager Loading pentru a include 'category' și 'tags'
          $tasks = Task::with(['category', 'tags'])->get();
        
          // Returnează vizualizarea 'tasks.index' cu datele sarcinilor
          return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return 'Afișează formularul pentru crearea unei sarcini';
    }

    public function store(Request $request)
    {
        // mai târziu
    }

    // 2. Metoda show: Obține detaliile unei sarcini individuale
    public function show($id)
    {
        
        // Folosește Eager Loading pentru a include relațiile
        $task = Task::with(['category', 'tags'])->findOrFail($id);

        // Returnează vizualizarea 'tasks.show' cu datele sarcinii
        return view('tasks.show', compact('task'));
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
