# 📋 QLCV_Laravel - Hệ thống Quản lý Công việc

Một ứng dụng web quản lý công việc (Task Management System) được phát triển bằng Laravel Framework, giúp doanh nghiệp tổ chức, theo dõi và quản lý công việc của nhân viên một cách hiệu quả.

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 📖 Giới thiệu

QLCV_Laravel là hệ thống quản lý công việc toàn diện với các tính năng:
- Tạo và phân công công việc cho nhân viên
- Theo dõi tiến độ và trạng thái công việc
- Hệ thống bình luận và thảo luận
- Phân quyền người dùng (Manager/Employee)
- Thông báo qua email khi có phân công mới
- Tìm kiếm và lọc công việc nhanh chóng

## ✨ Tính năng chi tiết

### 🎯 Quản lý Công việc (Tasks)
- **Tạo công việc mới**: Tạo task với tiêu đề, mô tả, thời gian bắt đầu/kết thúc
- **Cập nhật trạng thái**: Pending (Chờ xử lý), In Progress (Đang làm), Completed (Hoàn thành)
- **Phân công**: Gán công việc cho nhân viên cụ thể
- **Chi tiết công việc**: Xem đầy đủ thông tin task với modal detail
- **Chỉnh sửa và xóa**: Quyền chỉnh sửa dựa trên role

### 👥 Quản lý Nhân viên (Employees)
- **CRUD đầy đủ**: Thêm, sửa, xóa, xem danh sách nhân viên
- **Thông tin nhân viên**: Tên, email, vị trí công việc
- **Xem công việc được gán**: Danh sách task của từng nhân viên

### 💬 Hệ thống Bình luận (Comments)
- Bình luận trên từng công việc
- Hiển thị người comment và thời gian
- Xóa comment (chỉ người tạo hoặc manager)

### 🔐 Xác thực & Phân quyền
- **Đăng ký/Đăng nhập**: Hệ thống auth Laravel UI
- **Phân quyền**: 
  - **Manager**: Toàn quyền quản lý tasks, employees, phân công
  - **Employee**: Xem và cập nhật task được gán, bình luận
- **Quên mật khẩu**: Reset password qua email

### 🔍 Tìm kiếm & Lọc
- Tìm kiếm theo từ khóa tiêu đề
- Lọc theo trạng thái công việc
- Lọc theo nhân viên được gán

### 📧 Thông báo Email
- Tự động gửi email khi có task mới được phân công
- Template email tùy chỉnh với thông tin chi tiết task

## 🛠️ Công nghệ sử dụng

- **Backend**: Laravel 12.x
- **Frontend**: Blade Templates, Bootstrap 5
- **Database**: MySQL / PostgreSQL / SQLite
- **Authentication**: Laravel UI
- **Email**: Laravel Mail với Queue support
- **Build Tool**: Vite
- **Testing**: PHPUnit

## 📋 Yêu cầu hệ thống

- PHP >= 8.2
- Composer >= 2.0
- Node.js >= 18.x & npm >= 9.x
- MySQL >= 8.0 hoặc PostgreSQL >= 13 hoặc SQLite 3
- Web Server: Apache hoặc Nginx

## 🚀 Hướng dẫn cài đặt

### Bước 1: Clone dự án
```bash
git clone https://github.com/kazaki04/QLCV_Laravel.git
cd QLCV_Laravel
```

### Bước 2: Cài đặt PHP dependencies
```bash
composer install
```

### Bước 3: Cài đặt JavaScript dependencies
```bash
npm install
```

### Bước 4: Cấu hình môi trường

#### Tạo file .env
```bash
# Windows
copy .env.example .env

# Linux/MacOS
cp .env.example .env
```

#### Tạo Application Key
```bash
php artisan key:generate
```

#### Cấu hình Database trong `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=qlcv_laravel
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### Cấu hình Email (tùy chọn)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Bước 5: Tạo database và chạy migrations
```bash
# Tạo database (nếu chưa có)
mysql -u root -p -e "CREATE DATABASE qlcv_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Chạy migrations
php artisan migrate
```

### Bước 6: Seed dữ liệu mẫu (tùy chọn)
```bash
php artisan db:seed
```

Seeder sẽ tạo:
- Tài khoản Manager mẫu
- Một số nhân viên mẫu
- Dữ liệu task demo

### Bước 7: Build frontend assets
```bash
# Development
npm run dev

# Production
npm run build
```

### Bước 8: Khởi động server
```bash
php artisan serve
```

Truy cập ứng dụng tại: `http://localhost:8000`

### Bước 9: Cấu hình Queue Worker (nếu dùng email)
```bash
# Chạy queue worker trong terminal riêng
php artisan queue:work
```

## 📁 Cấu trúc dự án

```
QLCV_Laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/              # Controllers xác thực
│   │   │   ├── TaskController.php # Quản lý công việc
│   │   │   ├── EmployeeController.php
│   │   │   ├── CommentController.php
│   │   │   ├── MessageController.php
│   │   │   └── SearchController.php
│   │   ├── Middleware/
│   │   │   └── EnsureManager.php  # Middleware phân quyền
│   ├── Models/
│   │   ├── User.php               # Model người dùng
│   │   ├── Task.php               # Model công việc
│   │   └── Comment.php            # Model bình luận
│   ├── Policies/
│   │   ├── CommentPolicy.php      # Policy cho comments
│   │   └── UserPolicy.php         # Policy cho users
│   ├── Mail/
│   │   └── TaskAssigned.php       # Email thông báo
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/                # File migrations
│   │   ├── *_create_users_table.php
│   │   ├── *_create_tasks_table.php
│   │   ├── *_create_comments_table.php
│   │   ├── *_add_role_to_users_table.php
│   │   └── ...
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   └── ManagerSeeder.php      # Seeder tạo manager
│   └── factories/
│       └── UserFactory.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php      # Layout chính
│   │   ├── auth/                  # Views xác thực
│   │   ├── tasks/                 # Views quản lý task
│   │   ├── employees/             # Views quản lý nhân viên
│   │   ├── messages/              # Views tin nhắn
│   │   └── emails/                # Email templates
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php                    # Định nghĩa routes
│   └── console.php
├── tests/
│   ├── Feature/
│   │   ├── TaskAssignmentTest.php
│   │   └── EmployeeRoleTest.php
│   └── Unit/
├── .env.example                   # File cấu hình mẫu
├── composer.json                  # PHP dependencies
├── package.json                   # JS dependencies
└── README.md
```

## 🎨 Giao diện chính

### Dashboard
- Tổng quan công việc
- Danh sách task được gán
- Trạng thái công việc

### Quản lý Tasks
- `/tasks` - Danh sách tất cả công việc
- `/tasks/create` - Tạo công việc mới
- `/tasks/{id}/edit` - Chỉnh sửa công việc
- `/tasks/{id}` - Chi tiết công việc

### Quản lý Employees
- `/employees` - Danh sách nhân viên
- `/employees/create` - Thêm nhân viên mới
- `/employees/{id}/edit` - Chỉnh sửa thông tin
- `/employees/{id}` - Chi tiết nhân viên

## 👤 Tài khoản mẫu

Sau khi chạy seeder, bạn có thể đăng nhập với:

**Manager:**
- Email: manager@example.com
- Password: password123
**Hoặc đăng ký tài khoản mới tại** `/register`

## 🧪 Chạy Tests

```bash
# Chạy tất cả tests
php artisan test

# Chạy test cụ thể
php artisan test --filter=TaskAssignmentTest

# Chạy với coverage
php artisan test --coverage
```

## 🔧 Các lệnh hữu ích

```bash
# Xóa cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Tạo storage link (cho file upload)
php artisan storage:link

# Chạy migrations lại từ đầu
php artisan migrate:fresh --seed

# Xem danh sách routes
php artisan route:list

# Chạy queue worker
php artisan queue:work

# Chạy scheduler (cho cron jobs)
php artisan schedule:work
```

## 🐛 Troubleshooting

### Lỗi "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Lỗi permission denied với storage/logs
```bash
# Linux/MacOS
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Windows: chạy terminal as Administrator
icacls storage /grant Users:F /T
icacls bootstrap\cache /grant Users:F /T
```

### Email không gửi được
1. Kiểm tra cấu hình `.env` phần `MAIL_*`
2. Với Gmail: bật "App Password" thay vì password thường
3. Đảm bảo queue worker đang chạy: `php artisan queue:work`

### Database connection error
1. Kiểm tra MySQL/PostgreSQL đang chạy
2. Xác nhận thông tin `.env` chính xác
3. Tạo database nếu chưa có

## 🤝 Đóng góp

Em hoan nghênh mọi đóng góp! Vui lòng:

1. Fork dự án
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Mở Pull Request

## 📝 Todo List

- [ ] Thêm tính năng upload file đính kèm cho task
- [ ] Tích hợp real-time notifications với Laravel Echo
- [ ] Dashboard analytics với biểu đồ
- [ ] Export báo cáo Excel/PDF
- [ ] API RESTful cho mobile app
- [ ] Dark mode
- [ ] Multi-language support

## 📄 License

Dự án này được phát hành dưới giấy phép [MIT License](LICENSE).

## Người thực hiện
- Lê Trường Giang - 22010224
