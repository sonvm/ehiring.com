<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckRole
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
        $user_id=auth()->user()->id;
        $user_roles= DB::table('user_roles')->select('user_roles.role_id')->where('user_id','=',$user_id)->join('roles', 'user_roles.role_id', '=', 'roles.id')->select('roles.name')->get()->toArray();
        
        $u_roles=[];
        foreach ($user_roles as $user_role)
        {
            $u_roles[]= $user_role->name;
        }
        
        if (in_array($role,$u_roles)||in_array('admin',$u_roles)) return $next($request);
        else return redirect('/error');

        //return $next($request);
    }
}
