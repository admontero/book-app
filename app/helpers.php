<?php

if (! function_exists('add_classes_to_tags')) {
    function add_classes_to_tags(string $html = null, string $classes = ''): ?string
    {
        if (! $html) return null;

        return preg_replace('/<(\w+)/', '<$1 class="' . $classes . '"', $html);
    }
}
