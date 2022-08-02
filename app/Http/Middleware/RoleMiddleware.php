<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$role)
    {
        echo 'Vai trò:' . $role;
        echo '<br>Thực hiện khi đang xử lý HTTP response';
        return $next($request);
    }

    public function terminate($request, $response)
    {
        echo '<br>3. Terminable Middleware';
        echo '<br>Thực hiện sau khi HTTP response gửi đến trình duyệt';
    }
}
