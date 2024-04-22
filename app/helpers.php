<?php

if (! function_exists('add_classes_to_html_content')) {
    function add_classes_to_html_content(string $html = null, string $classes = ''): ?string
    {
        if (! $html) return null;

        return preg_replace('/<(\w+)/', '<$1 class="' . $classes . '"', $html);
    }
}

if (! function_exists('get_route_name_by_url')) {
    function get_route_name_by_url(string $url): string
    {
        return app('router')->getRoutes()->match(request()->create($url))->getName();
    }
}
