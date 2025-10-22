@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 animate__animated animate__fadeInDown">Chi tiết công việc</h2>
    <div class="card shadow animate__animated animate__fadeInUp">
        <div class="card-body">
            <h4 class="mb-3">{{ $task->title }}</h4>
            <p><strong>Mô tả:</strong> {{ $task->description }}</p>
            <p><strong>Trạng thái:</strong> <span class="badge bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'warning' : 'secondary') }}">{{ __($task->status) }}</span></p>
            <p><strong>Người thực hiện:</strong> {{ $task->assignee ? $task->assignee->name : '-' }}</p>
            <p><strong>Hạn chót:</strong> {{ $task->deadline ? date('d/m/Y', strtotime($task->deadline)) : '-' }}</p>
            @can('manage', App\Models\User::class)
            <div class="mb-3">
                <label class="form-label">Giao cho</label>
                <select id="assign-select" class="form-select">
                    <option value="">-- Chọn nhân viên --</option>
                    @foreach(App\Models\User::where('role','employee')->where('active', true)->orderBy('name')->get() as $u)
                        <option value="{{ $u->id }}" {{ $task->assigned_to == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            @endcan
            @can('manage', App\Models\User::class)
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning me-2 animate__animated animate__fadeInUp">Sửa</a>
            @endcan
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary animate__animated animate__fadeInLeft">Quay lại</a>
        </div>
    </div>
    <div class="card mt-4 shadow animate__animated animate__fadeInUp">
        <div class="card-body">
            <h5>Bình luận</h5>

            @auth
            <form action="{{ route('comments.store') }}" method="POST" class="mb-3">
                @csrf
                <input type="hidden" name="task_id" value="{{ $task->id }}">
                <div class="mb-2">
                    <textarea name="content" class="form-control" rows="3" placeholder="Viết bình luận..." required></textarea>
                </div>
                <button class="btn btn-primary btn-sm">Gửi</button>
            </form>
            @else
            <p><a href="{{ route('login') }}">Đăng nhập</a> để bình luận.</p>
            @endauth

            <div class="comments-list">
                @foreach($task->comments as $comment)
                    <div class="border rounded p-2 mb-2">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $comment->user->name }}</strong>
                                <small class="text-muted">— {{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                            <div>
                                @can('delete', $comment)
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-link btn-sm text-danger">Xóa</button>
                                </form>
                                @endcan
                                <button class="btn btn-link btn-sm reply-toggle">Trả lời</button>
                            </div>
                        </div>
                        <p class="mt-2 mb-1">{{ $comment->content }}</p>

                        {{-- Replies --}}
                        @if($comment->replies->count())
                            <div class="ms-4 mt-2">
                                @foreach($comment->replies as $reply)
                                    <div class="border rounded p-2 mb-2">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong>{{ $reply->user->name }}</strong>
                                                <small class="text-muted">— {{ $reply->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div>
                                                @can('delete', $reply)
                                                <form action="{{ route('comments.destroy', $reply) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-link btn-sm text-danger">Xóa</button>
                                                </form>
                                                @endcan
                                            </div>
                                        </div>
                                        <p class="mt-2 mb-1">{{ $reply->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Reply form (hidden) --}}
                        @auth
                        <form action="{{ route('comments.store') }}" method="POST" class="reply-form mt-2" style="display:none">
                            @csrf
                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <div class="mb-2">
                                <textarea name="content" class="form-control" rows="2" placeholder="Viết trả lời..." required></textarea>
                            </div>
                            <button class="btn btn-secondary btn-sm">Trả lời</button>
                            <button type="button" class="btn btn-link btn-sm cancel-reply">Hủy</button>
                        </form>
                        @endauth
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.reply-toggle').forEach(function(btn){
        btn.addEventListener('click', function(){
            var container = btn.closest('.border');
            var form = container.querySelector('.reply-form');
            if(form) form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        });
    });
    document.querySelectorAll('.cancel-reply').forEach(function(btn){
        btn.addEventListener('click', function(){
            var form = btn.closest('.reply-form');
            if(form) form.style.display = 'none';
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var select = document.getElementById('assign-select');
    if(select){
        select.addEventListener('change', function(){
            var assigned_to = select.value;
            fetch('{{ url('/tasks/'.$task->id.'/assign') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}'
                },
                body: JSON.stringify({ assigned_to: assigned_to })
            }).then(function(resp){
                return resp.json();
            }).then(function(json){
                // simple toast
                var el = document.createElement('div');
                el.className = 'toast align-items-center text-bg-success border-0';
                el.style.position = 'fixed';
                el.style.right = '16px';
                el.style.bottom = '16px';
                el.innerHTML = '<div class="d-flex"><div class="toast-body">' + (json.message || 'Giao việc thành công') + '</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>';
                document.body.appendChild(el);
                var bs = new bootstrap.Toast(el);
                bs.show();
                setTimeout(function(){ el.remove(); }, 5000);
            }).catch(function(){
                alert('Lỗi khi giao việc');
            });
        });
    }
});
</script>
@endpush
