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
