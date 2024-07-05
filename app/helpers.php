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

if (! function_exists('get_total_digits_in_a_number')) {
    function get_total_digits_in_a_number(int $number): string
    {
        return $number !== 0 ? floor(log10($number) + 1) : 1;
    }
}

if (! function_exists('get_decimal_digit_in_a_number')) {
    function get_decimal_digit_in_a_number(string $numberStr, int $decimalPos = 1): ?string
    {
        if (! is_numeric($numberStr) || $decimalPos < 1) {
            return null;
        }

        $dotPos = strpos($numberStr, '.');

        if ($dotPos === false || strlen($numberStr) <= $dotPos + $decimalPos) {
            return null;
        }

        $numberStr = strval($numberStr);

        return $numberStr[$dotPos + $decimalPos];
    }
}
