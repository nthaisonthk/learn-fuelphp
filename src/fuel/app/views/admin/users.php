

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-users"></i> Quản lý người dùng</h1>
            <a href="<?php echo Uri::base(); ?>admin/user_create" class="btn btn-success">
                <i class="fas fa-plus"></i> Thêm người dùng
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-list"></i> Danh sách người dùng</h5>
            </div>
            <div class="card-body">
                <?php if (empty($users)): ?>
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> Chưa có người dùng nào trong hệ thống.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên đăng nhập</th>
                                    <th>Email</th>
                                    <th>Vai trò</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo $user->id; ?></td>
                                        <td>
                                            <strong><?php echo $user->username; ?></strong>
                                            <?php if ($user->id == Auth::get_user_id()): ?>
                                                <span class="badge bg-primary">Bạn</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $user->email; ?></td>
                                        <td>
                                            <?php
                                            $roleClass = '';
                                            switch($user->group) {
                                                case 1: $roleClass = 'bg-secondary'; break;
                                                case 2: $roleClass = 'bg-info'; break;
                                                case 3: $roleClass = 'bg-danger'; break;
                                            }
                                            ?>
                                            <span class="badge <?php echo $roleClass; ?>">
                                                <?php echo $user->get_role_name(); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', $user->created_at); ?></td>
                                        <td>
                                            <a href="<?php echo Uri::base(); ?>admin/user_edit/<?php echo $user->id; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <?php if ($user->id != Auth::get_user_id()): ?>
                                                <a href="<?php echo Uri::base(); ?>admin/user_delete/<?php echo $user->id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div> 