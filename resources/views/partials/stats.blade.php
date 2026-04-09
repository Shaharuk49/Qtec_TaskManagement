{{-- resources/views/partials/stats.blade.php --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center h-100">
            <div class="card-body py-3">
                <div class="fs-2 fw-bold text-secondary">{{ $stats['total'] }}</div>
                <div class="small text-muted text-uppercase fw-semibold">Total</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center h-100">
            <div class="card-body py-3">
                <div class="fs-2 fw-bold text-warning">{{ $stats['pending'] }}</div>
                <div class="small text-muted text-uppercase fw-semibold">Pending</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center h-100">
            <div class="card-body py-3">
                <div class="fs-2 fw-bold text-primary">{{ $stats['in_progress'] }}</div>
                <div class="small text-muted text-uppercase fw-semibold">In Progress</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center h-100">
            <div class="card-body py-3">
                <div class="fs-2 fw-bold text-success">{{ $stats['completed'] }}</div>
                <div class="small text-muted text-uppercase fw-semibold">Completed</div>
            </div>
        </div>
    </div>
</div>