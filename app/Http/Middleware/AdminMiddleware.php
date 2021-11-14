<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()) {
            $user = User::where('id', Auth::id())
                ->first();

            if ($user) {
                if ($user->isAdmin() || $user->isCreator()) {
                    return $next($request);
                }
            }
        }

        abort(401);
    }
}
