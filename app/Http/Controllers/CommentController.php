<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'task_id' => $request->task_id,
            'parent_id' => $request->parent_id,
            'content' => $request->content,
        ]);

        return redirect()->route('tasks.show', $request->task_id)->with('success', 'Bình luận đã được thêm.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $taskId = $comment->task_id;
        $comment->delete();
        return redirect()->route('tasks.show', $taskId)->with('success', 'Bình luận đã được xóa.');
    }
}
