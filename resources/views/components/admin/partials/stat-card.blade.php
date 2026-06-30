@props([
    'icon' => 'package',
    'iconBg' => 'bg-red-50',
    'iconColor' => 'text-brand-red',
    'value' => '0',
    'label' => '',
    'link' => '#',
    'linkText' => '',
])

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100/80 hover:shadow-md transition-shadow duration-300">
    <div class="flex items-start justify-between mb-4">
        <div class="w-12 h-12 rounded-xl {{ $iconBg }} flex items-center justify-center">
            <i data-lucide="{{ $icon }}" class="w-6 h-6 {{ $iconColor }}"></i>
        </div>
    </div>
    <div class="text-3xl font-bold font-num text-brand-charcoal mb-1">{{ $value }}</div>
    <div class="text-sm text-gray-500 mb-3">{{ $label }}</div>
    @if($linkText)
    <a href="{{ $link }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-red hover:text-brand-red-dark transition-colors">
        {{ $linkText }}
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
    </a>
    @endif
</div>
