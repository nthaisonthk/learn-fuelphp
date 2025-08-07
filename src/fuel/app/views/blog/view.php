<div class="row">
    <div class="col-lg-8">
        <article class="blog-post">
            <header class="mb-4">
                <h1 class="display-5"><?php echo $post->title; ?></h1>
                <div class="text-muted mb-3">
                    <i class="fas fa-user"></i> <?php echo $post->user->username; ?> |
                    <i class="fas fa-calendar"></i> <?php echo date('d/m/Y H:i', $post->created_at); ?> |
                    <i class="fas fa-comments"></i> <?php echo count($comments); ?> comments
                </div>
                <?php if ($post->featured_image): ?>
                    <div class="post-featured-image">
                        <img src="<?php echo Uri::base() . 'assets/uploads/' . $post->featured_image; ?>" 
                             class="img-fluid rounded" 
                             alt="<?php echo $post->title; ?>">
                    </div>
                <?php endif; ?>
            </header>
            
            <div class="blog-content">
                <?php echo html_entity_decode($post->content, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        </article>
        
        <!-- Comments Section -->
        <div class="comment-section">
            <h4><i class="fas fa-comments"></i> Comments (<?php echo count($comments); ?>)</h4>
            
            <?php if (Auth::check()): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h6><i class="fas fa-edit"></i> Write a comment</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo Uri::base(); ?>blog/comment/<?php echo $post->id; ?>">
                            <div class="mb-3">
                                <textarea class="form-control" name="content" rows="3" placeholder="Write something..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Send
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <a href="<?php echo Uri::base(); ?>auth/login">Please Login</a> to write a comment.
                </div>
            <?php endif; ?>
            
            <?php if (empty($comments)): ?>
                <div class="alert alert-light text-center">
                    <i class="fas fa-comment-slash"></i> No comments yet. Be the first!
                </div>
            <?php else: ?>
                <div class="comments-list">
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1"><?php echo $comment->user->username; ?></h6>
                                        <small class="text-muted"><?php echo date('d/m/Y H:i', $comment->created_at); ?></small>
                                    </div>
                                    <p class="mb-1"><?php echo nl2br($comment->content); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.post-featured-image {
    margin-bottom: 2rem;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.post-featured-image img {
    width: 100%;
    height: auto;
    transition: transform 0.3s ease;
}

.post-featured-image:hover img {
    transform: scale(1.02);
}

.blog-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #2c3e50;
}

.blog-content p {
    margin-bottom: 1.5rem;
}

.blog-content h2, .blog-content h3, .blog-content h4 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #34495e;
}

.comment-section {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
}

.comment-item {
    padding: 1rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.comment-item:last-child {
    border-bottom: none;
}

@media (max-width: 768px) {
    .post-featured-image {
        margin-bottom: 1.5rem;
    }
    
    .blog-content {
        font-size: 1rem;
    }
}
</style>