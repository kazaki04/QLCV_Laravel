@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Chỉnh sửa nhân viên</h2>
    <form method="POST" action="{{ route('employees.update', $employee) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Tên</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mật khẩu (để trống nếu không đổi)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Chức vụ</label>
            <select name="role" class="form-select">
                <option value="employee" {{ $employee->role === 'employee' ? 'selected' : '' }}>Nhân viên</option>
                <option value="manager" {{ $employee->role === 'manager' ? 'selected' : '' }}>Quản lí</option>
            </select>
        </div>
        <button class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection