@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'text-xs text-red-600 dark:text-red-300 mt-1']) }}>{{ $message }}</p>
@enderror
