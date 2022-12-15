<?php

namespace Ecolso\Saas\Middlewares;

use Closure;
use Domain\Teams\Models\Team;
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

        if ($request->team instanceof Team) {
            $team = $request->team;
        } else {
            $team = Team::where('id', $request->team)->firstOrFail();
        }

        abort_unless($user->belongsToTeam($team), 404);

        app('currentTeam')->put($team);

        Inertia::share('current_team', fn() => $team);

        return $next($request);
    }
}
