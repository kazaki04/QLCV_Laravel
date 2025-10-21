
<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');

Auth::routes();
use App\Http\Controllers\TaskController;
Route::resource('tasks', TaskController::class);
Route::get('tasks/{task}/detail', [TaskController::class, 'detail'])->name('tasks.detail');
Route::post('tasks/{task}/assign', [TaskController::class, 'assign'])->name('tasks.assign');
use App\Http\Controllers\CommentController;
Route::post('comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MessageController;
Route::resource('employees', EmployeeController::class)->middleware('auth');
Route::get('messages', [MessageController::class, 'index'])->name('messages.index')->middleware('auth');


Route::get('/reset-session', function() {
	\Illuminate\Support\Facades\Session::flush();
	return redirect('/login');
});


