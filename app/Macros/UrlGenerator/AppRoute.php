<?php

namespace App\Macros\UrlGenerator;


/**
 * @mixin Illuminate\Routing\UrlGenerator
 *
 * @return Illuminate\Routing\UrlGenerator
 */
class AppRoute
{
    public function __invoke()
    {
        return function ($name, $parameters = [], $absolute = true) {
        };
    }
}
