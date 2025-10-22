@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="fw-bold mb-4">
                <i class="bi bi-person-circle"></i> Hồ sơ cá nhân
            </h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Thông tin cá nhân -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Thông tin cá nhân</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="row mb-3">
                            <label for="name" class="col-md-3 col-form-label fw-semibold">Họ và tên</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-3 col-form-label fw-semibold">Email</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($user->email_verified_at === null)
                                    <small class="text-warning">
                                        <i class="bi bi-exclamation-triangle"></i> Email chưa được xác thực
                                    </small>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label fw-semibold">Vai trò</label>
                            <div class="col-md-9">
                                <span class="badge {{ $user->role === 'manager' ? 'bg-success' : 'bg-secondary' }} fs-6">
                                    {{ $user->role === 'manager' ? 'Quản lý' : 'Nhân viên' }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label fw-semibold">Ngày tham gia</label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Đổi mật khẩu -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="bi bi-shield-lock"></i> Đổi mật khẩu</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="current_password" class="col-md-3 col-form-label fw-semibold">Mật khẩu hiện tại</label>
                            <div class="col-md-9">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-3 col-form-label fw-semibold">Mật khẩu mới</label>
                            <div class="col-md-9">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Tối thiểu 8 ký tự</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password_confirmation" class="col-md-3 col-form-label fw-semibold">Xác nhận mật khẩu</label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-key"></i> Cập nhật mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Xóa tài khoản -->
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Vùng nguy hiểm</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Khi bạn xóa tài khoản, toàn bộ dữ liệu sẽ bị xóa vĩnh viễn. 
                        Hành động này không thể hoàn tác.
                    </p>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="bi bi-trash"></i> Xóa tài khoản
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa tài khoản -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteAccountModalLabel">
                    <i class="bi bi-exclamation-triangle"></i> Xác nhận xóa tài khoản
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <strong>Cảnh báo!</strong> Hành động này không thể hoàn tác.
                    </div>
                    <p>Vui lòng nhập mật khẩu để xác nhận xóa tài khoản:</p>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           name="password" placeholder="Mật khẩu" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 12px;
        border: none;
    }
    .card-header {
        border-radius: 12px 12px 0 0 !important;
        font-weight: 600;
    }
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>
@endpush
