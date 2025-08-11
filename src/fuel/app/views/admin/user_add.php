<?php $title = 'Chỉnh sửa người dùng'; ?>

<div class="row">
    <div class="col-12">
        <h3 class="mb-4">
            <i class="fas fa-user-edit"></i> Add user
        </h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-edit"></i>User info</h5>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo Uri::base(); ?>auth/register">
                    <div class="mb-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required minlength="6">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="group" class="form-label">Role</label>
                        <select class="form-select" id="group" name="group">
                            <option value="3">Normal</option>
                            <option value="4">Author</option>
                            <option value="6">Admin</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo Uri::base(); ?>admin/users" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>