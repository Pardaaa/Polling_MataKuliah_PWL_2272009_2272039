<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        //Jika akun yang login sesuai dengan role
        //maka silahkan akses
        //jika tidak sesuai akan diarahkan ke home

        $roles = array_slice(func_get_args(), 2);

        if (Auth::check()) {
            $user = Auth::user()->role;

            foreach ($roles as $role) {
                if ($user == $role) {
                    return $next($request);
                }
            }
        }

        return redirect('/');
    }
}
