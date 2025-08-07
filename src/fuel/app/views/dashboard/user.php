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
                <h5><i class="fas fa-user-circle"></i> User information</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><strong>Username:</strong> <?php echo $user->username; ?></li>
                    <li><strong>Email:</strong> <?php echo $user->email; ?></li>
                    <li><strong>Register at:</strong> <?php echo date('d/m/Y', $user->created_at); ?></li>
                    <li><strong>Total comments:</strong> <?php echo count($comments); ?></li>
                    <li><strong>Total approved comments:</strong> <?php echo count($approved_comments); ?></li>
                    <li><strong>Total rejected comments:</strong> <?php echo $rejected_comments; ?></li>
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
                <h5><i class="fas fa-comments"></i> Recent comments</h5>
            </div>
            <div class="card-body">
                <?php if (empty($comments)): ?>
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> No comment.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Content</th>
                                    <th>Post</th>
                                    <th>Status</th>
                                    <th>Created at</th>
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
                                                <span class="badge bg-success">Approved</span>
                                            <?php elseif ($comment->is_pending()): ?>
                                                <span class="badge bg-warning">Pending</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Rejected</span>
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
