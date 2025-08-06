

<div class="row">
    <div class="col-12">
        <h4 class="mb-4">
            <i class="fas fa-user"></i> User Dashboard
        </h4>

        <p class="lead">Welcome, <?php echo $user->username; ?></p>
    </div>
</div>

<!-- User Info -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-user-circle"></i> Thông tin cá nhân</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><strong>Tên đăng nhập:</strong> <?php echo $user->username; ?></li>
                    <li><strong>Email:</strong> <?php echo $user->email; ?></li>
<!--                    <li><strong>Vai trò:</strong> --><?php //echo $user->get_role_name(); ?><!--</li>-->
                    <li><strong>Ngày tham gia:</strong> <?php echo date('d/m/Y', $user->created_at); ?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-pie"></i> Thống kê hoạt động</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="fas fa-comments"></i> <strong>Bình luận đã viết:</strong> <?php echo count($comments); ?></li>
                    <li><i class="fas fa-calendar"></i> <strong>Thành viên từ:</strong> <?php echo date('d/m/Y', $user->created_at); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Recent Comments -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-comments"></i> Bình luận gần đây</h5>
            </div>
            <div class="card-body">
                <?php if (empty($comments)): ?>
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> Bạn chưa có bình luận nào. 
                        <a href="<?php echo Uri::base(); ?>" class="btn btn-primary btn-sm ms-2">Đọc bài viết và bình luận</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nội dung</th>
                                    <th>Bài viết</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày viết</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($comments as $comment): ?>
                                    <tr>
                                        <td>
                                            <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis;">
                                                <?php echo substr($comment->content, 0, 100); ?>
                                                <?php if (strlen($comment->content) > 100): ?>...<?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?php echo Uri::base(); ?>blog/view/<?php echo $comment->post_id; ?>">
                                                <?php echo $comment->post->title; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php if ($comment->is_approved()): ?>
                                                <span class="badge bg-success">Đã duyệt</span>
                                            <?php elseif ($comment->is_pending()): ?>
                                                <span class="badge bg-warning">Chờ duyệt</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Bị từ chối</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', $comment->created_at); ?></td>
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

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5><i class="fas fa-book-open"></i> Đọc bài viết</h5>
            </div>
            <div class="card-body">
                <p>Khám phá các bài viết mới nhất từ cộng đồng.</p>
                <a href="<?php echo Uri::base(); ?>" class="btn btn-primary">
                    <i class="fas fa-book-open"></i> Xem bài viết
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5><i class="fas fa-comment"></i> Viết bình luận</h5>
            </div>
            <div class="card-body">
                <p>Tham gia thảo luận và chia sẻ ý kiến của bạn.</p>
                <a href="<?php echo Uri::base(); ?>" class="btn btn-success">
                    <i class="fas fa-comment"></i> Bình luận
                </a>
            </div>
        </div>
    </div>
</div> 