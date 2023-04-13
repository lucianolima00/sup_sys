<a {{ $attributes->merge(['class' => 'btn inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-800 border border-gray-800 rounded-md font-semibold text-xs text-gray-800 dark:text-white uppercase tracking-widest hover:bg-gray-100 dark:hover:bg-white focus:bg-white dark:focus:bg-gray-700 active:bg-gray-300 dark:active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
