@extends('layouts.app')

@section('title', 'All Tasks')

@section('content')

{{-- Page Header --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">Task Dashboard</h1>
        <p class="text-muted mb-0 small">Manage and track your team's tasks</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>New Task
    </a>
</div>

{{-- Stats Cards --}}
@include('partials.stats', ['stats' => $stats])

{{-- Filter Bar --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('tasks.index') }}" class="row g-2 align-items-end">
            <div class="col-12 col-md-4">
                <label class="form-label small fw-semibold mb-1">Search</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search tasks…" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="pending"     {{ request('status') === 'pending'     ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed"   {{ request('status') === 'completed'   ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold mb-1">Priority</label>
                <select name="priority" class="form-select form-select-sm">
                    <option value="">All Priority</option>
                    <option value="low"    {{ request('priority') === 'low'    ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high"   {{ request('priority') === 'high'   ? 'selected' : '' }}>High</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold mb-1">Sort By</label>
                <select name="sort" class="form-select form-select-sm">
                    <option value="latest"   {{ request('sort') === 'latest'   ? 'selected' : '' }}>Latest</option>
                    <option value="oldest"   {{ request('sort') === 'oldest'   ? 'selected' : '' }}>Oldest</option>
                    <option value="due_date" {{ request('sort') === 'due_date' ? 'selected' : '' }}>Due Date</option>
                </select>
            </div>
            <div class="col-6 col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Tasks Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
        <span class="fw-semibold">
            Tasks
            <span class="badge bg-secondary ms-1">{{ $tasks->total() }}</span>
        </span>
    </div>

    @if($tasks->isEmpty())
        <div class="card-body text-center py-5">
            <i class="bi bi-inbox display-4 text-muted d-block mb-3"></i>
            <h5 class="text-muted">No tasks found</h5>
            <p class="text-muted small mb-3">
                {{ request()->hasAny(['search','status','priority']) ? 'Try adjusting your filters.' : 'Get started by creating your first task.' }}
            </p>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i>Create Task
            </a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th>Created</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $loop->iteration + ($tasks->currentPage() - 1) * $tasks->perPage() }}</td>
                            <td>
                                <div class="fw-semibold">{{ Str::limit($task->title, 45) }}</div>
                                @if($task->description)
                                    <div class="text-muted small">{{ Str::limit($task->description, 60) }}</div>
                                @endif
                            </td>
                            <td>@include('partials.status-badge', ['status' => $task->status])</td>
                            <td>@include('partials.priority-badge', ['priority' => $task->priority])</td>
                            <td>
                                @if($task->due_date)
                                    <span class="{{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-danger fw-semibold' : 'text-muted' }} small">
                                        <i class="bi bi-calendar3 me-1"></i>{{ $task->due_date->format('d M Y') }}
                                        @if($task->due_date->isPast() && $task->status !== 'completed')
                                            <span class="badge bg-danger ms-1">Overdue</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $task->created_at->format('d M Y') }}</td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('tasks.show', $task) }}"
                                       class="btn btn-sm btn-outline-secondary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('tasks.edit', $task) }}"
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                          onsubmit="return confirm('Delete this task? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($tasks->hasPages())
            <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between">
                <small class="text-muted">
                    Showing {{ $tasks->firstItem() }}–{{ $tasks->lastItem() }} of {{ $tasks->total() }} tasks
                </small>
                {{ $tasks->withQueryString()->links() }}
            </div>
        @endif
    @endif
</div>

@endsection