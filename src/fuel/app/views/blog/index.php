

<div class="row">
    <div class="col-12">
        <h3 class="mb-4">
            <i class="fas fa-blog"></i> Blog
        </h3>
    </div>
</div>

<?php if (empty($posts)): ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Chưa có bài viết nào được đăng.
                <?php if (Auth::check() && Auth::get_user()->group_id >= 2): ?>
                    <a href="<?php echo Uri::base(); ?>author/post_create" class="btn btn-primary btn-sm ms-2">Tạo bài viết đầu tiên</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 post-card shadow-sm">
                    <?php if ($post->featured_image): ?>
                        <img src="<?php echo $post->featured_image; ?>" class="card-img-top" alt="<?php echo $post->title; ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $post->title; ?></h5>
                        <p class="card-text text-muted">
                            <small>
                                <i class="fas fa-user"></i> <?php echo $post->user->username; ?> |
                                <i class="fas fa-calendar"></i> <?php echo date('d/m/Y', $post->created_at); ?>
                            </small>
                        </p>
                        <p class="card-text"><?php echo $post->get_excerpt(100); ?></p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="<?php echo Uri::base(); ?>blog/view/<?php echo $post->id; ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> Đọc tiếp
                        </a>
                        <span class="badge bg-secondary float-end">
                            <i class="fas fa-comments"></i> <?php echo count($post->comments); ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?> 