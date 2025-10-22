@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Bảng điều khiển</h2>
        <!-- <div>Xin chào, <strong>{{ Auth::user()->name }}</strong></div> -->
    </div>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card p-3">
                <div class="text-muted">Tổng công việc</div>
                <div class="h3">{{ $totalTasks }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <div class="text-muted">Nhân viên (active)</div>
                <div class="h3">{{ $totalEmployees }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <div class="text-muted">Hoàn thành</div>
                <div class="h3">{{ $tasksByStatus['completed'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <div class="text-muted">Thời gian hoàn thành TB</div>
                <div class="h3">{{ $avgCompletionDays ?? '-' }} ngày</div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-5">
            <div class="card p-3 h-100">
                <h5>Phân bố trạng thái công việc</h5>
                <canvas id="tasksChart" height="250"></canvas>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card p-3">
                <h5>Các công việc gần đây</h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tiêu đề</th>
                                <th>Người được giao</th>
                                <th>Trạng thái</th>
                                <th>Start</th>
                                <th>End</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($recentTasks as $t)
                            <tr>
                                <td>{{ $t->title }}</td>
                                <td>{{ $t->assignee? $t->assignee->name : '-' }}</td>
                                <td>{{ $t->status }}</td>
                                <td>{{ $t->start_date? $t->start_date->format('d/m/Y') : '-' }}</td>
                                <td>{{ $t->end_date? $t->end_date->format('d/m/Y') : '-' }}</td>
                                <td><a href="{{ route('tasks.show', $t) }}" class="btn btn-sm btn-outline-primary">Xem</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6">Chưa có công việc.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Thông tin chi tiết</h5>
                <ul>
                    <li>Chưa làm: {{ $tasksByStatus['pending'] ?? 0 }}</li>
                    <li>Đang làm: {{ $tasksByStatus['in_progress'] ?? 0 }}</li>
                    <li>Hoàn thành: {{ $tasksByStatus['completed'] ?? 0 }}</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Chức năng nhanh</h5>
                <div class="d-flex gap-2 flex-wrap">
                    <a class="btn btn-outline-primary" href="{{ route('tasks.index') }}">Danh sách công việc</a>
                    <a class="btn btn-primary" href="{{ route('tasks.create') }}">Giao việc</a>
                    <a class="btn btn-outline-secondary" href="{{ route('employees.index') }}">Nhân viên</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var ctx = document.getElementById('tasksChart');
    if(!ctx) return;
    var data = {
        labels: ['Chưa làm','Đang làm','Hoàn thành'],
        datasets: [{
            data: [{{ $tasksByStatus['pending'] ?? 0 }}, {{ $tasksByStatus['in_progress'] ?? 0 }}, {{ $tasksByStatus['completed'] ?? 0 }}],
            backgroundColor: ['#6c757d','#ffc107','#198754'],
        }]
    };
    new Chart(ctx, { type: 'pie', data: data, options: { responsive: true } });
});
</script>
@endpush
