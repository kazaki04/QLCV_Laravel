@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="card p-3">
        <h3>{{ $employee->name }}</h3>
        <p><strong>Email:</strong> {{ $employee->email }}</p>
        <p><strong>Chức vụ:</strong> {{ $employee->role === 'manager' ? 'Quản lí' : 'Nhân viên' }}</p>
        <hr>
        <h5>Các công việc được giao</h5>
        @if($tasks->count())
            <ul class="list-group">
                @foreach($tasks as $t)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $t->title }}</strong>
                            <div><small class="text-muted">{{ $t->deadline ? date('d/m/Y', strtotime($t->deadline)) : '-' }}</small></div>
                        </div>
                        <a href="{{ route('tasks.show', $t) }}" class="btn btn-sm btn-info">Xem</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Chưa có công việc nào được giao.</p>
        @endif
    </div>
</div>
@endsection