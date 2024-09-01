<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $authorized = Auth::guard($guards)->guest() || Auth::guard(null)->guest();

        if(!$authorized) {
            if($request->ajax() || $request->wantsJson()) {
                return response()->json(["message" => "User Unauthorized. access denied"]);
            } else {
                return redirect("/login");
            }
        }
        return $next($request);
    }
}
