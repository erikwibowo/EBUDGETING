<?php

namespace App\Http\Middleware;

use App\Models\Otorisasi;
use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session('login_status')) {
            session()->flash('type', 'error');
            session()->flash('notif', 'Anda harus login terlebih dahulu');
            return redirect('admin/login');
        }
        return $next($request);
    }
}
