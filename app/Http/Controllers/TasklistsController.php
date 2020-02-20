<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tasklist; 

class TasklistsController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'tasks' => $tasklists,
            ];
            
            return view('tasks.index', $data);
        }
        
        return view('welcome', $data);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10',
        ]);

        $request->user()->tasklists()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect('/');
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10',
        ]);

        $tasklist = Tasklist::find($id);
        $tasklist->content = $request->content;
        $tasklist->status = $request->status;
        $tasklist->save();

        return redirect('/');
    }
    
    public function destroy($id)
    {
        $tasklist = \App\Tasklist::find($id);

        if (\Auth::id() === $tasklist->user_id) {
            $tasklist->delete();
        }

        return redirect('/');
    }
    
    public function create()
    {
        $task = new Tasklist;

        return view('tasks.create', [
            'task' => $task,
        ]);
    }
    
    public function show($id)
    {
        $task = Tasklist::find($id);
        if (\Auth::id() === $task->user_id) {
            return view('tasks.show', [
                'task' => $task,
            ]);
        }
        
        return redirect('/');
        
    }
    
    public function edit($id)
    {
        $task = Tasklist::find($id);
        if (\Auth::id() === $task->user_id) {
            return view('tasks.edit', [
                'task' => $task,
            ]);
        }
    
         return redirect('/');
    }
}
