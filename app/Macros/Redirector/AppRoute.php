<?php

namespace App\Macros\Redirector;


/**
 * @mixin Illuminate\Routing\Redirector
 *
 * @return \Illuminate\Http\RedirectResponse
 */
class AppRoute
{
    public function __invoke()
    {
        return function ($route, $parameters = [], $status = 302, $headers = []): \Illuminate\Http\RedirectResponse {
            $defaultParameters = [
                'team' => app('currentTeam')->get(),
                'year' => app('currentYear')->get(),
            ];

            return $this->to($this->generator->route("app.{$route}", array_merge($parameters, $defaultParameters)), $status, $headers);
        };
    }
}
