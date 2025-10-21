<div class="p-3">
    <div class="d-flex align-items-start">
        <div class="me-3">
            <img src="https://img.icons8.com/fluency/48/000000/task.png" alt="task">
        </div>
        <div>
            <h5 class="mb-1">{{ $task->title }}</h5>
            <p class="mb-1"><strong>Trạng thái:</strong> <span class="badge bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'warning' : 'secondary') }}">{{ __($task->status) }}</span></p>
            <p class="mb-1"><strong>Hạn chót:</strong> {{ $task->deadline ? date('d/m/Y', strtotime($task->deadline)) : '-' }}</p>
            <hr>
            <p>{!! nl2br(e($task->description ?: '-')) !!}</p>
        </div>
    </div>

    <hr>
    <div class="mt-3">
        <h6>Bình luận</h6>
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
+                            @auth
+                            <button class="btn btn-link btn-sm reply-toggle">Trả lời</button>
+                            @endauth
                        </div>
                    </div>
                    <p class="mt-2 mb-1">{{ $comment->content }}</p>

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