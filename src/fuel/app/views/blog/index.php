

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
                <i class="fas fa-info-circle"></i> Empty post.
                <?php if (Auth::check() && Auth::get_user()->group_id == ROLE_AUTHOR): ?>
                    <a href="<?php echo Uri::base(); ?>author/post_create" class="btn btn-primary btn-sm ms-2">Create the first post</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 post-card">
                    <!-- Thumbnail -->
                    <div class="post-thumbnail">
                        <?php if ($post->featured_image): ?>
                            <img src="<?php echo Uri::base() . 'assets/uploads/' . $post->featured_image; ?>" 
                                 class="card-img-top post-thumbnail-img" 
                                 alt="<?php echo $post->title; ?>">
                        <?php else: ?>
                            <div class="post-thumbnail-placeholder">
                                <i class="fas fa-image"></i>
                                <span>No Image</span>
                            </div>
                        <?php endif; ?>
                        <div class="post-status-badge">
                            <?php if ($post->is_published()): ?>
                                <span class="badge bg-success">Published</span>
                            <?php else: ?>
                                <span class="badge bg-warning">Draft</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title post-title"><?php echo $post->title; ?></h5>
                        <p class="card-text text-muted post-meta">
                            <small>
                                <i class="fas fa-user"></i> <?php echo $post->user->username; ?> |
                                <i class="fas fa-calendar"></i> <?php echo date('d/m/Y', $post->created_at); ?>
                            </small>
                        </p>
                        <p class="card-text post-excerpt"><?php echo $post->get_excerpt(100); ?></p>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?php echo Uri::base(); ?>blog/view/<?php echo $post->id; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Read post
                                </a>
                                <span class="badge bg-secondary">
                                    <i class="fas fa-comments"></i> <?php echo count($post->comments); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>