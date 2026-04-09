{{-- resources/views/partials/priority-badge.blade.php --}}
{{-- Usage: @include('partials.priority-badge', ['priority' => $task->priority]) --}}

@php
    $map = [
        'low'    => ['badge bg-secondary', 'bi-arrow-down',    'Low'],
        'medium' => ['badge bg-info text-dark', 'bi-dash',     'Medium'],
        'high'   => ['badge bg-danger',    'bi-arrow-up',      'High'],
    ];
    [$cls, $icon, $label] = $map[$priority] ?? ['badge bg-secondary', 'bi-dash', ucfirst($priority)];
@endphp

<span class="{{ $cls }}">
    <i class="bi {{ $icon }} me-1"></i>{{ $label }}
</span>