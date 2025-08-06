<?php $title = 'Chỉnh sửa người dùng'; ?>

<div class="row">
    <div class="col-12">
        <h1 class="mb-4">
            <i class="fas fa-user-edit"></i> Chỉnh sửa người dùng
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-edit"></i> Thông tin người dùng</h5>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo Uri::base(); ?>admin/user_edit/<?php echo $user->id; ?>">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user->username; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user->email; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="group" class="form-label">Vai trò</label>
                        <select class="form-select" id="group" name="group">
                            <option value="1" <?php echo $user->group == 1 ? 'selected' : ''; ?>>Normal</option>
                            <option value="2" <?php echo $user->group == 2 ? 'selected' : ''; ?>>Author</option>
                            <option value="3" <?php echo $user->group == 3 ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo Uri::base(); ?>admin/users" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Thông tin người dùng</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><strong>ID:</strong> <?php echo $user->id; ?></li>
                    <li><strong>Ngày tạo:</strong> <?php echo date('d/m/Y H:i', $user->created_at); ?></li>
                    <li><strong>Lần đăng nhập cuối:</strong> 
                        <?php echo $user->last_login ? date('d/m/Y H:i', $user->last_login) : 'Chưa đăng nhập'; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div> 