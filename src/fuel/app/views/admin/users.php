

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="fas fa-users"></i> User Management</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-list"></i> Users list</h5>
            </div>
            <div class="card-body">
                <?php if (empty($users)): ?>
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> No users in the system
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo $user->id; ?></td>
                                        <td>
                                            <strong><?php echo $user->username; ?></strong>
                                            <?php if ($user->id == Auth::get_user_id()): ?>
                                                <span class="badge bg-primary">You</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $user->email; ?></td>
                                        <td>
                                            <?php
                                            $group_id = $user->group_id;
                                            $group = Model_UserGroup::find($group_id);
                                            $group_name = $group ? $group->name : 'Unknown';
                                            $roleClass = 'bg-primary'; //default
                                            switch($group_id) {
                                                case ROLE_USER: $roleClass = 'bg-secondary'; break; //normal user
                                                case ROLE_AUTHOR: $roleClass = 'bg-info'; break; //  author
                                                case ROLE_ADMIN: $roleClass = 'bg-danger'; break; // super admin
                                            }
                                            ?>
                                            <span class="badge <?php echo $roleClass; ?>">
                                                <?php echo $group_name; ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', $user->created_at); ?></td>
                                        <td>
                                            <a href="<?php echo Uri::base(); ?>admin/user_edit/<?php echo $user->id; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <?php if ($user->id != Auth::get_user_id()): ?>
                                                <a href="<?php echo Uri::base(); ?>admin/user_delete/<?php echo $user->id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                                    <i class="fas fa-trash"></i> Delete
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