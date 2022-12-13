<?php

if ( ! function_exists('src_path'))
{
    /**
     * Get the src path.
     *
     * @param  string $path
     * @return string
     */
    function src_path($path = '')
    {
        return app()->basePath() . '/src' . ($path ? '/' . $path : $path);
    }
}

if ( ! function_exists('app_route'))
{
    /**
     * Get the src path.
     *
     * @param  string $path
     * @return string
     */
    function app_route($name, $parameters = [], $absolute = true)
    {
        return app('url')->appRoute($name, $parameters, $absolute);
    }
}
