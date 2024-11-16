<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;
use App\Models\Tag;

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
    $categories = Category::all(); // Preia toate categoriile
    $tags = Tag::all(); // Preia toate etichetele

    return view('tasks.create', compact('categories', 'tags')); // Trimite datele către view
}


public function store(Request $request)
{
    // Validează datele introduse
    $validated = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'category_id' => 'required|exists:categories,id',
    ]);

    // Creează sarcina
    $task = Task::create($validated);

    // Atașează etichetele
    if ($request->has('tags')) {
        $task->tags()->attach($request->tags);
    }

    return redirect()->route('tasks.index')->with('success', 'Sarcina a fost creată cu succes!');
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
        $task = Task::with('tags')->findOrFail($id); // Găsește sarcina și etichetele asociate
        $categories = Category::all(); // Preia toate categoriile
        $tags = Tag::all(); // Preia toate etichetele
    
        return view('tasks.edit', compact('task', 'categories', 'tags'));
    }
    

    public function update(Request $request, $id)
{
    $task = Task::findOrFail($id);

    // Validează datele introduse
    $validated = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'category_id' => 'required|exists:categories,id',
    ]);

    // Actualizează sarcina
    $task->update($validated);

    // Actualizează etichetele
    $task->tags()->sync($request->tags);

    return redirect()->route('tasks.index')->with('success', 'Sarcina a fost actualizată cu succes!');
}


public function destroy($id)
{
    $task = Task::findOrFail($id);
    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Sarcina a fost ștearsă cu succes!');
}

}
