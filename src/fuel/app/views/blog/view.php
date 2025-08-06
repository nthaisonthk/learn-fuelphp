

<div class="row">
    <div class="col-lg-8">
        <article class="blog-post">
            <header class="mb-4">
                <h1 class="display-5"><?php echo $post->title; ?></h1>
                <div class="text-muted mb-3">
                    <i class="fas fa-user"></i> <?php echo $post->user->username; ?> |
                    <i class="fas fa-calendar"></i> <?php echo date('d/m/Y H:i', $post->created_at); ?> |
                    <i class="fas fa-comments"></i> <?php echo count($comments); ?> bình luận
                </div>
                <?php if ($post->featured_image): ?>
                    <img src="<?php echo $post->featured_image; ?>" class="img-fluid rounded mb-4" alt="<?php echo $post->title; ?>">
                <?php endif; ?>
            </header>
            
            <div class="blog-content">
                <?php echo nl2br($post->content); ?>
            </div>
        </article>
        
        <!-- Comments Section -->
        <div class="comment-section">
            <h3><i class="fas fa-comments"></i> Bình luận (<?php echo count($comments); ?>)</h3>
            
            <?php if (Auth::check()): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-edit"></i> Viết bình luận</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo Uri::base(); ?>blog/comment/<?php echo $post->id; ?>">
                            <div class="mb-3">
                                <textarea class="form-control" name="content" rows="4" placeholder="Viết bình luận của bạn..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Gửi bình luận
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <a href="<?php echo Uri::base(); ?>auth/login">Đăng nhập</a> để viết bình luận.
                </div>
            <?php endif; ?>
            
            <?php if (empty($comments)): ?>
                <div class="alert alert-light text-center">
                    <i class="fas fa-comment-slash"></i> Chưa có bình luận nào. Hãy là người đầu tiên!
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
                                    
                                    <?php if (Auth::check()): ?>
                                        <button class="btn btn-sm btn-outline-primary reply-btn" data-comment-id="<?php echo $comment->id; ?>">
                                            <i class="fas fa-reply"></i> Trả lời
                                        </button>
                                        
                                        <div class="reply-form mt-2" id="reply-form-<?php echo $comment->id; ?>" style="display: none;">
                                            <form method="post" action="<?php echo Uri::base(); ?>blog/comment/<?php echo $post->id; ?>">
                                                <input type="hidden" name="parent_id" value="<?php echo $comment->id; ?>">
                                                <div class="mb-2">
                                                    <textarea class="form-control form-control-sm" name="content" rows="2" placeholder="Viết trả lời..." required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-paper-plane"></i> Gửi
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-sm cancel-reply" data-comment-id="<?php echo $comment->id; ?>">
                                                    Hủy
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Thông tin bài viết</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="fas fa-user"></i> <strong>Tác giả:</strong> <?php echo $post->user->username; ?></li>
                    <li><i class="fas fa-calendar"></i> <strong>Ngày đăng:</strong> <?php echo date('d/m/Y', $post->created_at); ?></li>
                    <li><i class="fas fa-clock"></i> <strong>Giờ đăng:</strong> <?php echo date('H:i', $post->created_at); ?></li>
                    <li><i class="fas fa-comments"></i> <strong>Bình luận:</strong> <?php echo count($comments); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reply functionality
    const replyBtns = document.querySelectorAll('.reply-btn');
    const cancelBtns = document.querySelectorAll('.cancel-reply');
    
    replyBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const replyForm = document.getElementById('reply-form-' + commentId);
            replyForm.style.display = 'block';
            this.style.display = 'none';
        });
    });
    
    cancelBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const replyForm = document.getElementById('reply-form-' + commentId);
            const replyBtn = document.querySelector('[data-comment-id="' + commentId + '"]');
            replyForm.style.display = 'none';
            replyBtn.style.display = 'inline-block';
        });
    });
});
</script> 