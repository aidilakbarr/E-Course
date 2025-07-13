@props(['href', 'active' => false, 'icon' => ''])

@php
    $classes = $active ? 'active-nav-link text-white' : 'text-white opacity-75 hover:opacity-100';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => "flex items-center py-4 pl-6 nav-item $classes"]) }}>
    @if ($icon)
        <i class="fas {{ $icon }} mr-3"></i>
    @endif
    {{ $slot }}
</a>
