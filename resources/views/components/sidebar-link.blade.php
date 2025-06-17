@props([
    'icon' => 'fa-circle',
    'active' => false,
])
<li class="nav-item {{ $active ? 'active':' ' }}">
    <a class="nav-link" {{ $attributes }}>
        <i class="fas fa-fw {{ $icon }}"></i>
        <span>{{ $slot }}</span></a>
</li>