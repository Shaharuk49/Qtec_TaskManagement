@extends('layouts.app')

@section('title', $task->title)

@section('content')

{{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Tasks</a></li>
        <li class="breadcrumb-item active">{{ Str::limit($task->title, 40) }}</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm">

            {{-- Card Header --}}
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-start justify-content-between gap-3">
                <div>
                    <h4 class="fw-bold mb-1">{{ $task->title }}</h4>
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        @include('partials.status-badge',   ['status'   => $task->status])
                        @include('partials.priority-badge', ['priority' => $task->priority])
                    </div>
                </div>
                <div class="d-flex gap-2 flex-shrink-0">
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                          onsubmit="return confirm('Delete this task permanently?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash me-1"></i>Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="card-body p-4">

                {{-- Description --}}
                <div class="mb-4">
                    <h6 class="text-uppercase fw-semibold text-muted small mb-2">
                        <i class="bi bi-card-text me-1"></i>Description
                    </h6>
                    @if($task->description)
                        <p class="mb-0">{{ $task->description }}</p>
                    @else
                        <p class="text-muted fst-italic mb-0">No description provided.</p>
                    @endif
                </div>

                <hr>

                {{-- Meta Details --}}
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <div class="small text-muted text-uppercase fw-semibold mb-1">Status</div>
                        @include('partials.status-badge', ['status' => $task->status])
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="small text-muted text-uppercase fw-semibold mb-1">Priority</div>
                        @include('partials.priority-badge', ['priority' => $task->priority])
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="small text-muted text-uppercase fw-semibold mb-1">Due Date</div>
                        <div class="small">
                            @if($task->due_date)
                                <span class="{{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-danger fw-semibold' : '' }}">
                                    <i class="bi bi-calendar3 me-1"></i>{{ $task->due_date->format('d M Y') }}
                                </span>
                                @if($task->due_date->isPast() && $task->status !== 'completed')
                                    <span class="badge bg-danger ms-1">Overdue</span>
                                @elseif(!$task->due_date->isPast())
                                    <div class="text-muted">{{ $task->due_date->diffForHumans() }}</div>
                                @endif
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="small text-muted text-uppercase fw-semibold mb-1">Created</div>
                        <div class="small">
                            <i class="bi bi-clock me-1"></i>{{ $task->created_at->format('d M Y') }}
                            <div class="text-muted">{{ $task->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- Quick Status Update --}}
                <div>
                    <h6 class="text-uppercase fw-semibold text-muted small mb-3">
                        <i class="bi bi-arrow-repeat me-1"></i>Quick Status Update
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(['pending' => ['warning', 'clock', 'Pending'], 'in_progress' => ['primary', 'arrow-repeat', 'In Progress'], 'completed' => ['success', 'check-circle', 'Completed']] as $value => [$color, $icon, $label])
                            <form action="{{ route('tasks.update', $task) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="title"       value="{{ $task->title }}">
                                <input type="hidden" name="status"      value="{{ $value }}">
                                <input type="hidden" name="priority"    value="{{ $task->priority }}">
                                <input type="hidden" name="description" value="{{ $task->description }}">
                                <input type="hidden" name="due_date"    value="{{ $task->due_date?->format('Y-m-d') }}">
                                <button type="submit"
                                        class="btn btn-sm btn-{{ $task->status === $value ? $color : 'outline-'.$color }} {{ $task->status === $value ? 'disabled' : '' }}">
                                    <i class="bi bi-{{ $icon }} me-1"></i>{{ $label }}
                                    @if($task->status === $value)
                                        <i class="bi bi-check ms-1"></i>
                                    @endif
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-muted small">
                Last updated {{ $task->updated_at->diffForHumans() }}
                &bull; ID: #{{ $task->id }}
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Back to Tasks
            </a>
        </div>
    </div>
</div>

@endsection