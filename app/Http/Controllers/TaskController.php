<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssigned;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderByDesc('created_at')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('manage', \App\Models\User::class);
        $users = \App\Models\User::where('role','employee')->where('active', true)->orderBy('name')->get();
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->authorize('manage', \App\Models\User::class);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'deadline' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        $task = Task::create($request->only(['title','description','status','deadline','start_date','end_date','assigned_to']));
        if($task->assigned_to){
            $user = \App\Models\User::find($task->assigned_to);
            if($user && $user->email){
                Mail::to($user->email)->send(new TaskAssigned($task));
            }
        }
        return redirect()->route('tasks.index')->with('success', 'Thêm công việc thành công!');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function detail(Task $task)
    {
        return view('tasks.partials.detail-modal', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorize('manage', \App\Models\User::class);
        $users = \App\Models\User::where('role','employee')->where('active', true)->orderBy('name')->get();
        return view('tasks.edit', compact('task','users'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('manage', \App\Models\User::class);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'deadline' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        $oldAssigned = $task->assigned_to;
        $task->update($request->only(['title','description','status','deadline','start_date','end_date','assigned_to']));

        if($task->assigned_to && $task->assigned_to != $oldAssigned){
            $user = \App\Models\User::find($task->assigned_to);
            if($user && $user->email){
                Mail::to($user->email)->send(new TaskAssigned($task));
            }
        }
        return redirect()->route('tasks.index')->with('success', 'Cập nhật công việc thành công!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Xóa công việc thành công!');
    }

    public function assign(Request $request, Task $task)
    {
        $this->authorize('manage', \App\Models\User::class);
        $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        $old = $task->assigned_to;
        $task->assigned_to = $request->assigned_to;
        $task->save();
        if($task->assigned_to && $task->assigned_to != $old){
            $user = \App\Models\User::find($task->assigned_to);
            if($user && $user->email){
                Mail::to($user->email)->send(new TaskAssigned($task));
            }
        }
        return response()->json(['success' => true, 'message' => 'Giao việc thành công']);
    }
}
