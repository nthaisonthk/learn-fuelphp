

<div class="row">
    <div class="col-12">
        <h1 class="mb-4">
            <i class="fas fa-tachometer-alt"></i> Admin Dashboard
        </h1>
        <p class="lead">Chào mừng, <?php echo $user->username; ?>! Bạn đang quản lý hệ thống với quyền Admin.</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card admin-stats">
            <div class="card-body text-center">
                <i class="fas fa-users fa-3x mb-3"></i>
                <h3><?php echo $total_users; ?></h3>
                <p class="mb-0">Tổng số người dùng</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card admin-stats">
            <div class="card-body text-center">
                <i class="fas fa-file-alt fa-3x mb-3"></i>
                <h3><?php echo $total_posts; ?></h3>
                <p class="mb-0">Tổng số bài viết</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card admin-stats">
            <div class="card-body text-center">
                <i class="fas fa-comments fa-3x mb-3"></i>
                <h3><?php echo $total_comments; ?></h3>
                <p class="mb-0">Tổng số bình luận</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-3x mb-3"></i>
                <h3><?php echo $pending_comments; ?></h3>
                <p class="mb-0">Bình luận chờ duyệt</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-users"></i> Quản lý người dùng</h5>
            </div>
            <div class="card-body">
                <p>Quản lý tất cả người dùng trong hệ thống, phân quyền và cập nhật thông tin.</p>
                <a href="<?php echo Uri::base(); ?>admin/users" class="btn btn-primary">
                    <i class="fas fa-users"></i> Quản lý người dùng
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-file-alt"></i> Quản lý bài viết</h5>
            </div>
            <div class="card-body">
                <p>Quản lý tất cả bài viết, duyệt bài viết và xóa bài viết không phù hợp.</p>
                <a href="<?php echo Uri::base(); ?>admin/posts" class="btn btn-success">
                    <i class="fas fa-file-alt"></i> Quản lý bài viết
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-comments"></i> Quản lý bình luận</h5>
            </div>
            <div class="card-body">
                <p>Duyệt và quản lý bình luận từ người dùng, loại bỏ spam và nội dung không phù hợp.</p>
                <a href="<?php echo Uri::base(); ?>admin/comments" class="btn btn-info">
                    <i class="fas fa-comments"></i> Quản lý bình luận
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-bar"></i> Thống kê hệ thống</h5>
            </div>
            <div class="card-body">
                <p>Xem thống kê chi tiết về hoạt động của hệ thống và người dùng.</p>
                <a href="<?php echo Uri::base(); ?>admin/stats" class="btn btn-secondary">
                    <i class="fas fa-chart-bar"></i> Xem thống kê
                </a>
            </div>
        </div>
    </div>
</div> 