<?php $title = 'Quản lý bài viết'; ?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4><i class="fas fa-file-alt"></i> Post management</h4>
            <a href="<?php echo Uri::base(); ?>author/post_create" class="btn btn-success">
                <i class="fas fa-plus"></i> Create new post
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-list"></i> List of your posts</h5>
            </div>
            <div class="card-body">
                <?php if (empty($posts)): ?>
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> Empty post.
                        <a href="<?php echo Uri::base(); ?>author/post_create" class="btn btn-primary btn-sm ms-2">Tạo bài viết đầu tiên</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th>Comments</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($posts as $post): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo $post->title; ?></strong>
                                            <?php if ($post->is_published()): ?>
                                                <a href="<?php echo Uri::base(); ?>blog/view/<?php echo $post->id; ?>" class="btn btn-sm btn-outline-primary ms-2">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($post->is_published()): ?>
                                                <span class="badge bg-success">Published</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Draft</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', $post->created_at); ?></td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-comments"></i> <?php echo count($post->comments); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?php echo Uri::base(); ?>author/post_edit/<?php echo $post->id; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="<?php echo Uri::base(); ?>author/post_delete/<?php echo $post->id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                                <i class="fas fa-trash"></i> Delete
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