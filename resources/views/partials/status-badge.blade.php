{{-- resources/views/partials/status-badge.blade.php --}}
{{-- Usage: @include('partials.status-badge', ['status' => $task->status]) --}}

@php
    $map = [
        'pending'     => ['badge bg-warning text-dark', 'bi-clock',          'Pending'],
        'in_progress' => ['badge bg-primary',           'bi-arrow-repeat',   'In Progress'],
        'completed'   => ['badge bg-success',           'bi-check-circle',   'Completed'],
    ];
    [$cls, $icon, $label] = $map[$status] ?? ['badge bg-secondary', 'bi-question', ucfirst($status)];
@endphp

<span class="{{ $cls }}">
    <i class="bi {{ $icon }} me-1"></i>{{ $label }}
</span>