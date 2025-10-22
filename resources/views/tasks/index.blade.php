@extends('layouts.app')

@section('content')
<a href="{{ route('home') }}" style="position:absolute;top:24px;left:24px;z-index:10;text-decoration:none;">
    <img src="https://img.icons8.com/ios-filled/40/7f53ac/home.png" alt="Home" title="Về trang chính" style="vertical-align:middle;">
</a>
<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold animate__animated animate__fadeInDown">Danh sách công việc</h2>
        @can('manage', App\Models\User::class)
            <a href="{{ route('tasks.create') }}" class="btn btn-primary animate__animated animate__pulse animate__infinite">+ Thêm công việc</a>
        @endcan
    </div>
    @if(session('success'))
        <div class="alert alert-success animate__animated animate__fadeIn">{{ session('success') }}</div>
    @endif
    <div class="card shadow animate__animated animate__fadeInUp">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Trạng thái</th>
                        <th>Người thực hiện</th>
                        <th>Hạn chót</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    <tr class="align-middle animate__animated animate__fadeIn">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $task->title }}</td>
                        <td>
                            <span class="badge bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'warning' : 'secondary') }}">
                                {{ __($task->status) }}
                            </span>
                        </td>
                        <td>{{ $task->assignee ? $task->assignee->name : '-' }}</td>
                        <td>{{ $task->deadline ? date('d/m/Y', strtotime($task->deadline)) : '-' }}</td>
                        <td>
                            <button type="button" class="btn btn-secondary btn-sm me-1 detail-btn" 
                                data-id="{{ $task->id }}"
                                data-title="{{ e($task->title) }}"
                                data-description="{{ e($task->description) }}"
                                data-status="{{ $task->status }}"
                                data-deadline="{{ $task->deadline ? date('d/m/Y', strtotime($task->deadline)) : '-' }}"
                            >Mô tả chi tiết</button>
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm me-1 animate__animated animate__fadeInLeft">Xem</a>
                            @can('manage', App\Models\User::class)
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm me-1 animate__animated animate__fadeInUp">Sửa</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm animate__animated animate__fadeInRight" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Chưa có công việc nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endpush

@push('scripts')
<!-- Detail modal -->
<div class="modal fade" id="taskDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mô tả chi tiết công việc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="task-detail-container">
                    <div class="text-center py-5">Đang tải...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
        var modalElem = document.getElementById('taskDetailModal');
        var bsModal = new bootstrap.Modal(modalElem);
        document.querySelectorAll('.detail-btn').forEach(function(btn){
            btn.addEventListener('click', function(){
                var row = btn.closest('tr');
                // try to find task id from an attribute on row or button; we'll embed id on button
                var taskId = btn.dataset.id || btn.getAttribute('data-id');
                if(!taskId){
                    // fallback: try to read first cell number and map to tasks array - but we prefer data-id
                }
                var container = document.getElementById('task-detail-container');
                container.innerHTML = '<div class="text-center py-5">Đang tải...</div>';
                fetch('/tasks/' + (btn.dataset.id || taskId) + '/detail')
                    .then(function(resp){ return resp.text(); })
                    .then(function(html){
                        container.innerHTML = html;
                        bsModal.show();
                    })
                    .catch(function(){
                        container.innerHTML = '<div class="text-danger">Không thể tải nội dung.</div>';
                        bsModal.show();
                    });
            });
        });
});
</script>
@endpush
