<?php $title = 'Quản lý bình luận'; ?>

<div class="row">
    <div class="col-12">
        <h1 class="mb-4">
            <i class="fas fa-comments"></i> Quản lý bình luận
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-list"></i> Danh sách tất cả bình luận</h5>
            </div>
            <div class="card-body">
                <?php if (empty($comments)): ?>
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> Chưa có bình luận nào trong hệ thống.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nội dung</th>
                                    <th>Người viết</th>
                                    <th>Bài viết</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày viết</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($comments as $comment): ?>
                                    <tr>
                                        <td><?php echo $comment->id; ?></td>
                                        <td>
                                            <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis;">
                                                <?php echo substr($comment->content, 0, 100); ?>
                                                <?php if (strlen($comment->content) > 100): ?>...<?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?php echo $comment->user->username; ?></span>
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
                                        <td>
                                            <?php if ($comment->is_pending()): ?>
                                                <a href="<?php echo Uri::base(); ?>admin/comment_approve/<?php echo $comment->id; ?>" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-check"></i> Duyệt
                                                </a>
                                                <a href="<?php echo Uri::base(); ?>admin/comment_reject/<?php echo $comment->id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn từ chối bình luận này?')">
                                                    <i class="fas fa-times"></i> Từ chối
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Đã xử lý</span>
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