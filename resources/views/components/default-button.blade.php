<button {{ $attributes->merge(['type' => 'button', 'class' => 'flex items-center px-4 py-2 font-medium tracking-wide text-gray-600 capitalize
    transition-colors duration-300 transform bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80']) }}>
    {{ $slot }}
</button>

