<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RegistersUsers;

class HomeController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {


    }

    /**

     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalTasks = \App\Models\Task::count();
        $tasksByStatus = \App\Models\Task::select('status', \DB::raw('count(*) as cnt'))->groupBy('status')->pluck('cnt','status')->toArray();
        $totalEmployees = \App\Models\User::where('role','employee')->where('active', true)->count();

        $completedTasks = \App\Models\Task::where('status','completed')->whereNotNull('start_date')->whereNotNull('end_date')->get();
        $avgCompletionDays = null;
        if($completedTasks->count()){
            $totalDays = $completedTasks->reduce(function($carry, $t){
                $s = \Carbon\Carbon::parse($t->start_date);
                $e = \Carbon\Carbon::parse($t->end_date);
                return $carry + max(0, $e->diffInDays($s));
            }, 0);
            $avgCompletionDays = round($totalDays / $completedTasks->count(), 1);
        }

        $recentTasks = \App\Models\Task::with('assignee')->orderByDesc('created_at')->limit(8)->get();

        return view('home', compact('totalTasks','tasksByStatus','totalEmployees','avgCompletionDays','recentTasks'));
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return redirect()->route('login')->with('success', 'Đăng kí thành công, bạn sẽ được chuyển về trang đăng nhập');
    }
}


