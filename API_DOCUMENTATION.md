# API Documentation - User Management

## Tổng quan
API để quản lý users trong hệ thống blog FuelPHP. API này cung cấp các endpoint RESTful để thực hiện CRUD operations trên users.

## Base URL
```
http://localhost:8080/api/user
```

## Authentication
Tất cả các API endpoints yêu cầu authentication. Chỉ admin mới có quyền truy cập đầy đủ.

## Endpoints

### 1. GET /api/user
**Lấy danh sách tất cả users**

**Quyền truy cập:** Admin only

**Response:**
```json
{
    "status": "success",
    "message": "Users retrieved successfully",
    "data": {
        "total": 3,
        "users": [
            {
                "id": 1,
                "username": "admin",
                "email": "admin@example.com",
                "group_id": 6,
                "role": "Admin",
                "created_at": "2025-01-07 10:30:00",
                "updated_at": "2025-01-07 10:30:00"
            },
            {
                "id": 2,
                "username": "author1",
                "email": "author1@example.com",
                "group_id": 4,
                "role": "Author",
                "created_at": "2025-01-07 11:00:00",
                "updated_at": "2025-01-07 11:00:00"
            }
        ]
    }
}
```

**Error Response (401 Unauthorized):**
```json
{
    "status": "error",
    "message": "Unauthorized access"
}
```

**Error Response (403 Forbidden):**
```json
{
    "status": "error",
    "message": "Access denied. Admin only."
}
```

### 2. GET /api/user/{id}
**Lấy thông tin chi tiết của một user**

**Quyền truy cập:** Admin hoặc chính user đó

**Parameters:**
- `id` (required): ID của user

**Response:**
```json
{
    "status": "success",
    "message": "User retrieved successfully",
    "data": {
        "id": 1,
        "username": "admin",
        "email": "admin@example.com",
        "group_id": 6,
        "role": "Admin",
        "created_at": "2025-01-07 10:30:00",
        "updated_at": "2025-01-07 10:30:00"
    }
}
```

**Error Response (404 Not Found):**
```json
{
    "status": "error",
    "message": "User not found"
}
```

### 3. POST /api/user
**Tạo user mới**

**Quyền truy cập:** Admin only

**Request Body:**
```json
{
    "username": "newuser",
    "email": "newuser@example.com",
    "password": "password123",
    "group_id": 3
}
```

**Parameters:**
- `username` (required): Tên đăng nhập
- `email` (required): Email
- `password` (required): Mật khẩu
- `group_id` (optional): ID role (default: 3 - Normal User)

**Response (201 Created):**
```json
{
    "status": "success",
    "message": "User created successfully",
    "data": {
        "id": 4,
        "username": "newuser",
        "email": "newuser@example.com",
        "group_id": 3,
        "role": "Normal User"
    }
}
```

**Error Response (400 Bad Request):**
```json
{
    "status": "error",
    "message": "Username, email and password are required"
}
```

**Error Response (400 Bad Request - Duplicate):**
```json
{
    "status": "error",
    "message": "Username already exists"
}
```

### 4. PUT /api/user/{id}
**Cập nhật thông tin user**

**Quyền truy cập:** Admin hoặc chính user đó

**Parameters:**
- `id` (required): ID của user

**Request Body:**
```json
{
    "username": "updateduser",
    "email": "updated@example.com",
    "password": "newpassword",
    "group_id": 4
}
```

**Parameters (all optional):**
- `username`: Tên đăng nhập mới
- `email`: Email mới
- `password`: Mật khẩu mới
- `group_id`: ID role mới (chỉ admin mới có thể thay đổi)

**Response:**
```json
{
    "status": "success",
    "message": "User updated successfully",
    "data": {
        "id": 1,
        "username": "updateduser",
        "email": "updated@example.com",
        "group_id": 4,
        "role": "Author"
    }
}
```

### 5. DELETE /api/user/{id}
**Xóa user**

**Quyền truy cập:** Admin only

**Parameters:**
- `id` (required): ID của user

**Response:**
```json
{
    "status": "success",
    "message": "User deleted successfully"
}
```

**Error Response (400 Bad Request):**
```json
{
    "status": "error",
    "message": "Cannot delete your own account"
}
```

## Role Constants

| Constant | Value | Description |
|----------|-------|-------------|
| ROLE_USER | 3 | Normal User |
| ROLE_AUTHOR | 4 | Author |
| ROLE_ADMIN | 6 | Admin |

## HTTP Status Codes

| Code | Description |
|------|-------------|
| 200 | OK - Request successful |
| 201 | Created - Resource created successfully |
| 400 | Bad Request - Invalid parameters |
| 401 | Unauthorized - Authentication required |
| 403 | Forbidden - Insufficient permissions |
| 404 | Not Found - Resource not found |
| 500 | Internal Server Error - Server error |

## Error Handling

Tất cả các API endpoints đều trả về JSON response với format chuẩn:

**Success Response:**
```json
{
    "status": "success",
    "message": "Operation message",
    "data": { ... }
}
```

**Error Response:**
```json
{
    "status": "error",
    "message": "Error description"
}
```

## Testing với cURL

### Lấy danh sách users
```bash
curl -X GET http://localhost:8080/api/user \
  -H "Content-Type: application/json" \
  -H "Cookie: fuelcid=your_session_cookie"
```

### Tạo user mới
```bash
curl -X POST http://localhost:8080/api/user \
  -H "Content-Type: application/json" \
  -H "Cookie: fuelcid=your_session_cookie" \
  -d '{
    "username": "testuser",
    "email": "test@example.com",
    "password": "password123",
    "group_id": 3
  }'
```

### Cập nhật user
```bash
curl -X PUT http://localhost:8080/api/user/1 \
  -H "Content-Type: application/json" \
  -H "Cookie: fuelcid=your_session_cookie" \
  -d '{
    "email": "updated@example.com"
  }'
```

### Xóa user
```bash
curl -X DELETE http://localhost:8080/api/user/2 \
  -H "Content-Type: application/json" \
  -H "Cookie: fuelcid=your_session_cookie"
```

## Security Considerations

1. **Authentication Required**: Tất cả endpoints yêu cầu đăng nhập
2. **Authorization**: Chỉ admin mới có quyền truy cập đầy đủ
3. **Input Validation**: Tất cả input được validate
4. **SQL Injection Protection**: Sử dụng ORM để bảo vệ
5. **Password Hashing**: Mật khẩu được hash trước khi lưu
6. **Self-Protection**: User không thể xóa chính mình

## Rate Limiting

Hiện tại chưa có rate limiting. Có thể thêm trong tương lai.

## Future Enhancements

1. **Pagination**: Thêm pagination cho danh sách users
2. **Search/Filter**: Thêm tìm kiếm và lọc users
3. **Bulk Operations**: Thêm operations cho nhiều users
4. **Audit Log**: Ghi log các thay đổi
5. **API Versioning**: Thêm versioning cho API 