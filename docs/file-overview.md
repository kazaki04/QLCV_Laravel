# Tổng quan cấu trúc và vai trò các tệp trong dự án

Tài liệu này giúp bạn (và cộng tác viên) hiểu nhanh từng loại tệp/thư mục trong dự án Laravel này có tác dụng gì, và khi nào cần chỉnh sửa chúng.

## Thư mục gốc (root)
- `artisan`: CLI của Laravel. Dùng để chạy lệnh artisan (migrate, route:list, queue:work, v.v.).
- `composer.json` / `composer.lock`: Khai báo và khoá phiên bản các package PHP (Laravel và thư viện phụ). Sửa khi thêm/bớt package PHP, rồi chạy `composer install`.
- `package.json` / `package-lock.json`: Khai báo và khoá phiên bản các package JS (Vite, Bootstrap, v.v.). Sửa khi thêm/bớt dependency frontend, rồi chạy `npm install`.
- `phpunit.xml`: Cấu hình PHPUnit/Laravel Test. Chỉnh để cấu hình test suites, coverage, hoặc environment khi chạy test.
- `vite.config.js`: Cấu hình Vite để build asset (CSS/JS). Chỉnh khi cần alias, plugins, hoặc đường dẫn output.
- `README.md`: Tài liệu hướng dẫn sử dụng và phát triển dự án.

## `app/` – Mã nguồn ứng dụng (Backend)
- `app/Http/Controllers/`: Nơi đặt các controller xử lý request và trả response.
  - Ví dụ: `TaskController.php` (CRUD công việc), `EmployeeController.php`, `CommentController.php`, …
- `app/Http/Middleware/`: Lớp trung gian xử lý request trước khi tới controller (phân quyền, throttle, …).
  - Ví dụ: `EnsureManager.php` để kiểm tra quyền manager.
- `app/Models/`: Các Eloquent Model ánh xạ bảng CSDL và định nghĩa quan hệ.
  - Ví dụ: `User.php`, `Task.php`, `Comment.php`.
- `app/Policies/`: Chính sách phân quyền ở mức tài nguyên (model-level authorization) dùng với Gate/Policy.
  - Ví dụ: `CommentPolicy.php`, `UserPolicy.php`.
- `app/Providers/`: Service providers để bind service container, đăng ký event, macro, …
  - Ví dụ: `AppServiceProvider.php`.
- `app/Mail/`: Lớp mailer định nghĩa nội dung email gửi đi.
  - Ví dụ: `TaskAssigned.php` (email khi phân công task).

## `bootstrap/`
- `app.php`, `providers.php`: Bootstrap core của Laravel, khởi tạo ứng dụng và load providers.
- `bootstrap/cache/`: Tệp cache cấu hình/route/view để tăng hiệu năng (tự động tạo bởi artisan).

## `config/`
Các file cấu hình cho framework và package: `app.php`, `auth.php`, `cache.php`, `database.php`, `filesystems.php`, `logging.php`, `mail.php`, `queue.php`, `services.php`, `session.php`.
- Sửa khi cần thay đổi cấu hình (ví dụ mailer, queue connection, logging channel, …).

## `database/`
- `migrations/`: Định nghĩa cấu trúc bảng (schema). Chạy bằng `php artisan migrate`.
  - Ví dụ: tạo bảng users, tasks, comments, thêm cột vai trò, thời hạn, …
- `seeders/`: Sinh dữ liệu mẫu (user manager, tasks demo). Chạy bằng `php artisan db:seed`.
  - Ví dụ: `DatabaseSeeder.php`, `ManagerSeeder.php`.
- `factories/`: Factory tạo dữ liệu giả cho test/seeding. Ví dụ: `UserFactory.php`.
- `.gitignore`: Bỏ qua file DB nội bộ (dump, sqlite) tránh đưa lên repo.

## `public/`
- `index.php`: Entry point cho web server (Apache/Nginx) trỏ DocumentRoot vào thư mục này.
- `robots.txt`, `favicon.ico`, assets tĩnh đã build (nếu publish ra public).

## `resources/`
- `views/`: Blade templates cho giao diện (layouts, auth, tasks, employees, messages, search, …).
- `css/`, `sass/`, `js/`: Nguồn frontend (CSS/SCSS/JS) để Vite build.

## `routes/`
- `web.php`: Khai báo route web (HTTP, có session/csrf). Tại đây gắn controller cho tasks, employees, comments, …
- `console.php`: Đăng ký artisan command (schedule, command tùy chỉnh).

## `storage/`
- `app/`, `framework/`, `logs/`: Nơi lưu file upload, cache (views, routes, config), logs. Cần cấp quyền ghi cho web server.
- Lệnh hữu ích: `php artisan storage:link` tạo symlink `public/storage`.

## `tests/`
- `Feature/`: Test luồng nghiệp vụ end-to-end (HTTP, middleware, policy).
  - Ví dụ: `TaskAssignmentTest.php`, `EmployeeRoleTest.php`.
- `Unit/`: Test đơn vị cho class/logic thuần.
- `TestCase.php`: Base test case tích hợp Laravel.

## Các tệp ẩn/cấu hình bổ trợ
- `.env` / `.env.example`: Cấu hình môi trường (DB, MAIL, QUEUE, APP_KEY). Không commit `.env` thật.
- `.gitattributes`: Quy định thuộc tính file trong git (EOL, export-ignore, …).
- `.editorconfig`: Quy ước định dạng code giữa các editor (indent, charset, EOL, …).

## Khi nào chỉnh ở đâu?
- Thêm API hoặc trang mới → tạo route ở `routes/web.php` và controller ở `app/Http/Controllers/`.
- Thay đổi CSDL → thêm/sửa migration trong `database/migrations/` rồi chạy migrate.
- Thay đổi giao diện → sửa Blade trong `resources/views/` và build asset với Vite.
- Bổ sung phân quyền → tạo/sửa policy ở `app/Policies/` và đăng ký trong `AuthServiceProvider` (nếu dùng).
- Gửi email mới → tạo mailable ở `app/Mail/` và cấu hình SMTP trong `.env` + `config/mail.php`.
- Nâng cao hiệu năng → dùng cache config/route/view (artisan `config:cache`, `route:cache`, `view:cache`) và kiểm soát ở `bootstrap/cache/`.

## Quy ước commit gợi ý
- `feat(tasks): ...` – Tính năng mới cho module tasks
- `fix(auth): ...` – Sửa lỗi liên quan auth
- `docs(readme): ...` – Cập nhật tài liệu
- `chore(npm): ...` – Cập nhật công cụ/phụ trợ, không ảnh hưởng runtime
- `test: ...` – Bổ sung/điều chỉnh test

---
Tài liệu này nhằm làm rõ vai trò từng phần để dễ onboard, bảo trì và phát triển tính năng mới.