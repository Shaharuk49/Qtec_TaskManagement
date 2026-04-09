@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')

{{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Tasks</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('tasks.show', $task) }}">{{ Str::limit($task->title, 30) }}</a>
        </li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-pencil-square me-2"></i>Edit Task
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('tasks.update', $task) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">
                            Task Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="title" id="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $task->title) }}"
                               placeholder="Enter a clear, concise task title"
                               autofocus>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Provide additional details about the task (optional)">{{ old('description', $task->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- Status --}}
                        <div class="col-12 col-md-4">
                            <label for="status" class="form-label fw-semibold">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select name="status" id="status"
                                    class="form-select @error('status') is-invalid @enderror">
                                <option value="pending"     {{ old('status', $task->status) === 'pending'     ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>🔄 In Progress</option>
                                <option value="completed"   {{ old('status', $task->status) === 'completed'   ? 'selected' : '' }}>✅ Completed</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Priority --}}
                        <div class="col-12 col-md-4">
                            <label for="priority" class="form-label fw-semibold">
                                Priority <span class="text-danger">*</span>
                            </label>
                            <select name="priority" id="priority"
                                    class="form-select @error('priority') is-invalid @enderror">
                                <option value="low"    {{ old('priority', $task->priority) === 'low'    ? 'selected' : '' }}>🟢 Low</option>
                                <option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                                <option value="high"   {{ old('priority', $task->priority) === 'high'   ? 'selected' : '' }}>🔴 High</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Due Date --}}
                        <div class="col-12 col-md-4">
                            <label for="due_date" class="form-label fw-semibold">Due Date</label>
                            <input type="date" name="due_date" id="due_date"
                                   class="form-control @error('due_date') is-invalid @enderror"
                                   value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Meta info --}}
                    <div class="alert alert-light border small mb-3">
                        <i class="bi bi-info-circle me-1 text-muted"></i>
                        Created <strong>{{ $task->created_at->format('d M Y, h:i A') }}</strong>
                        &bull; Last updated <strong>{{ $task->updated_at->diffForHumans() }}</strong>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex gap-2 pt-2 border-top">
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="bi bi-save me-1"></i>Save Changes
                        </button>
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-x-lg me-1"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection