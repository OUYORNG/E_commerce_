<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::all();
        // dd($tasks);
        return view('task', compact('tasks'));
    }

    public function create(){
        return view('tasks.create');
    }

    public function store(Request $request){
        $request->validate([
            'title' => ['required','string','max:255'],
        ]);

        Task::create(['title'=>$request->title,]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }

    public function edit($id){
        $task = Task::find($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => ['required','string','max:255'],
        ]);

        $task = Task::find($id);
        $task->update(['title'=>$request->title,'is_completed'=>$request->has('is_completed')]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    public function destroy(Task $task){
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
}
