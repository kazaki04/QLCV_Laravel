<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%'.$request->keyword.'%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        $tasks = $query->get();
        return view('search.index', compact('tasks'));
    }
}
