@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="mb-4" style="color:#7f53ac;font-weight:bold;">Danh sách nhân viên</h2>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">+ Tạo nhân viên</a>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên nhân viên</th>
                <th>Email</th>
                <th>Chức vụ</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->id }}</td>
                <td><a href="{{ route('employees.show', $employee) }}">{{ $employee->name }}</a></td>
                <td>{{ $employee->email }}</td>
                <td>
                    @if($employee->role === 'manager')
                        <span class="badge bg-success">Quản lí</span>
                    @else
                        <span class="badge bg-secondary">Nhân viên</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
