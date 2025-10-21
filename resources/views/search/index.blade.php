@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2 class="mb-4" style="color:#7f53ac;font-weight:bold;">Tìm kiếm & lọc công việc</h2>
    <form method="GET" action="{{ route('search.index') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="keyword" class="form-control" placeholder="Từ khóa tiêu đề..." value="{{ request('keyword') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">-- Trạng thái --</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Chưa làm</option>
                    <option value="in_progress" {{ request('status')=='in_progress'?'selected':'' }}>Đang làm</option>
                    <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Hoàn thành</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="employee_id" class="form-control" placeholder="ID nhân viên" value="{{ request('employee_id') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Lọc</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Trạng thái</th>
                <th>Nhân viên</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->employee_id }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
