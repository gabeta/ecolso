<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResolveTeamMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        $team = Team::where('id', $request->team)->firstOrFail();

        abort_unless($user->belongsTo($team), 404);

        app('currentTeam')->put($team);

        Inertia::share('current_team', fn() => $team);

        return $next($request);
    }
}
