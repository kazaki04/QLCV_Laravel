<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureManager
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if(!$user || $user->role !== 'manager'){
            abort(403, 'Chỉ quản lí mới được phép thao tác này.');
        }
        return $next($request);
    }
}
