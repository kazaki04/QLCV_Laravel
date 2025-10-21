@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 animate__animated animate__fadeInDown">Chỉnh sửa công việc</h2>
    <div class="card shadow animate__animated animate__fadeInUp">
        <div class="card-body">
            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $task->title }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ $task->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="deadline" class="form-label">Hạn chót</label>
                    <input type="date" name="deadline" id="deadline" class="form-control" value="{{ $task->deadline ? $task->deadline->format('Y-m-d') : '' }}">
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Ngày bắt đầu</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $task->start_date ? $task->start_date->format('Y-m-d') : '' }}">
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">Ngày kết thúc</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $task->end_date ? $task->end_date->format('Y-m-d') : '' }}">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select name="status" id="status" class="form-select">
                        <option value="pending" @if($task->status=='pending') selected @endif>Chưa làm</option>
                        <option value="in_progress" @if($task->status=='in_progress') selected @endif>Đang làm</option>
                        <option value="completed" @if($task->status=='completed') selected @endif>Hoàn thành</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="assigned_to" class="form-label">Giao cho</label>
                    <select name="assigned_to" id="assigned_to" class="form-select">
                        <option value="">-- Chọn nhân viên --</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ $task->assigned_to == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->role === 'manager' ? 'Quản lí' : 'Nhân viên' }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-warning animate__animated animate__pulse animate__infinite">Cập nhật</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endpush
