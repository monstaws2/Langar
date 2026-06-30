<li class="mb-1">
    <a {{ $attributes->merge(['class' => ($active ?? false) ? 'block w-full text-left py-2 px-4 text-sm font-semibold text-[#C0392B] bg-gray-800 rounded-md transition duration-150 ease-in-out' : 'block w-full text-left py-2 px-4 text-sm font-medium text-gray-300 hover:text-[#C0392B] hover:bg-gray-700 focus:outline-none focus:text-[#C0392B] focus:bg-gray-700 transition duration-150 ease-in-out']) }}>
        {{ $slot }}
    </a>
</li>
