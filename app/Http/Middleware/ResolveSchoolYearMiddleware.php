<?php

namespace App\Http\Middleware;

use App\Models\Landlord\SchoolYear;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResolveSchoolYearMiddleware
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
        $year = SchoolYear::where('slug', $request->year)->first();

        if (is_null($year)) {
            $year = SchoolYear::where('is_current', 1)->first();

            return redirect()->route('app.dashboard', ['team' => $request->team, 'year' => $year]);
        }

        Inertia::share('all_years', fn() => SchoolYear::latest('begin_at')->get());
        Inertia::share('current_year', fn() => $year);

        app('currentYear')->put($year);

        return $next($request);
    }
}
