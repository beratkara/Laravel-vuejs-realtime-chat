<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class CheckUpdate
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
        if (auth()->user())
        {
            $user = User::query()->where('id', auth()->id())->first();

            $user->update([
                'last_check_at' => Carbon::now()
            ]);
        }
        return $next($request);
    }
}
