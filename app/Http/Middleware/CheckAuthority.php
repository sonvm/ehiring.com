<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckAuthority
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    private function checkOwner($request){
        var_dump($request);
        return false;
    }

    public function handle(Request $request, Closure $next,$resource)
    {

        $user_id=auth()->user()->id;
        $isAdmin= DB::table('user_roles')
        ->select('user_roles.role_id')
        ->where('user_id','=',$user_id)
        ->join('roles', 'user_roles.role_id', '=', 'roles.id')
        ->where('name','=','admin')
        ->exists();

        if ($isAdmin) return $next($request);

        switch($resource){
            case 'cv':break;//hb
            case 'career':
                if (!$this->checkOwner($request))
                return redirect('/error');
                break;//owner
            case 'rating':break;//self+owner
        }

        //echo 'not admin';
        return $next($request);
    }
}
