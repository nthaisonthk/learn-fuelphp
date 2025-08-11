# Blog System - FuelPHP

Hệ thống blog được xây dựng bằng FuelPHP với các chức năng quản lý người dùng, bài viết và bình luận.

## Tính năng

### Người dùng (Normal)
- Đăng ký và đăng nhập
- Xem bài viết
- Viết bình luận
- Dashboard cá nhân

### Tác giả (Author)
- Tất cả quyền của Normal user
- Tạo, chỉnh sửa, xóa bài viết
- Quản lý bài viết của mình

### Quản trị viên (Admin)
- Tất cả quyền của Author
- Quản lý tất cả người dùng
- Quản lý tất cả bài viết
- Duyệt bình luận
- Thống kê hệ thống

## Cài đặt

### Yêu cầu hệ thống
- PHP 7.4+
- MySQL 5.7+
- Composer
- Apache/Nginx

### Cài đặt dự án

1. Clone repository:
```bash
git clone <repository-url>
cd fuelphp
```

2. Cài đặt dependencies:
```bash
cd src
composer install
```

3. Cấu hình database:
- Copy `src/fuel/app/config/db.php` và cấu hình thông tin database
- Copy `src/fuel/app/config/auth.php` nếu cần

4. Chạy migrations:
```bash
php oil refine migrate
```

5. Cấu hình web server:
- Trỏ document root đến thư mục `src/public`
- Đảm bảo mod_rewrite được bật (Apache)

## Cấu trúc dự án

```
src/
├── fuel/
│   ├── app/
│   │   ├── classes/
│   │   │   ├── controller/
│   │   │   │   ├── auth.php
│   │   │   │   ├── blog.php
│   │   │   │   ├── dashboard.php
│   │   │   │   ├── admin.php
│   │   │   │   └── author.php
│   │   │   └── model/
│   │   │       ├── user.php
│   │   │       ├── post.php
│   │   │       └── comment.php
│   │   ├── views/
│   │   │   ├── auth/
│   │   │   ├── blog/
│   │   │   ├── dashboard/
│   │   │   ├── admin/
│   │   │   └── author/
│   │   ├── migrations/
│   │   └── config/
│   └── public/
└── composer.json
```

## Sử dụng

1. Truy cập trang chủ: `http://localhost/`
2. Đăng ký tài khoản mới
3. Đăng nhập và sử dụng các tính năng

## Phân quyền

- **Normal (group_id = 1)**: Chỉ đọc và bình luận
- **Author (group_id = 2)**: Có thể tạo bài viết
- **Admin (group_id = 3)**: Quản trị toàn bộ hệ thống

## Công nghệ sử dụng

- **Backend**: FuelPHP 1.9
- **Frontend**: Bootstrap 5.1.3, Font Awesome 6.0
- **Database**: MySQL
- **Authentication**: OrmAuth

## Đóng góp

1. Fork dự án
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

## License

MIT License 