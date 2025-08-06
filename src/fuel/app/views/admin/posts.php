<?php $title = 'Quản lý bài viết'; ?>

<div class="row">
    <div class="col-12">
        <h1 class="mb-4">
            <i class="fas fa-file-alt"></i> Quản lý bài viết
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-list"></i> Danh sách tất cả bài viết</h5>
            </div>
            <div class="card-body">
                <?php if (empty($posts)): ?>
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> Chưa có bài viết nào trong hệ thống.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tiêu đề</th>
                                    <th>Tác giả</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($posts as $post): ?>
                                    <tr>
                                        <td><?php echo $post->id; ?></td>
                                        <td>
                                            <strong><?php echo $post->title; ?></strong>
                                            <?php if ($post->is_published()): ?>
                                                <a href="<?php echo Uri::base(); ?>blog/view/<?php echo $post->id; ?>" class="btn btn-sm btn-outline-primary ms-2">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?php echo $post->user->username; ?></span>
                                        </td>
                                        <td>
                                            <?php if ($post->is_published()): ?>
                                                <span class="badge bg-success">Đã xuất bản</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Bản nháp</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', $post->created_at); ?></td>
                                        <td>
                                            <a href="<?php echo Uri::base(); ?>admin/post_edit/<?php echo $post->id; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="<?php echo Uri::base(); ?>admin/post_delete/<?php echo $post->id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                                <i class="fas fa-trash"></i> Xóa
                                            </a>
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