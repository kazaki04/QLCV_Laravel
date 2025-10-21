@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Tạo nhân viên mới</h2>
    <form method="POST" action="{{ route('employees.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Chức vụ</label>
            <select name="role" class="form-select">
                <option value="employee">Nhân viên</option>
                <option value="manager">Quản lí</option>
            </select>
        </div>
        <button class="btn btn-primary">Tạo</button>
    </form>
</div>
@endsection