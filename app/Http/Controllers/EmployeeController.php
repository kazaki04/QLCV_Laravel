<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
    $employees = User::all();
        return view('employees.index', compact('employees'));
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('manage', User::class);
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $this->authorize('manage', User::class);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:manager,employee',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('employees.index')->with('success', 'Nhân viên đã được tạo.');
    }

    public function edit(User $employee)
    {
        $this->authorize('manage', User::class);
        return view('employees.edit', compact('employee'));
    }

    public function show(User $employee)
    {
        $tasks = \App\Models\Task::where('assigned_to', $employee->id)->orderByDesc('created_at')->get();
        return view('employees.show', compact('employee','tasks'));
    }

    public function update(Request $request, User $employee)
    {
        $this->authorize('manage', User::class);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'role' => 'required|in:manager,employee',
        ]);

        $employee->update($request->only(['name','email','role']));
        if($request->filled('password')){
            $request->validate(['password' => 'nullable|string|min:6|confirmed']);
            $employee->password = Hash::make($request->password);
            $employee->save();
        }

        return redirect()->route('employees.index')->with('success', 'Nhân viên đã được cập nhật.');
    }

    public function destroy(User $employee)
    {
        $this->authorize('manage', User::class);
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Nhân viên đã được xóa.');
    }
}
