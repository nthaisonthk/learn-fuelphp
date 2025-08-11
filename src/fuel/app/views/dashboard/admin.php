<div class="row">
    <div class="col-12">
        <h4 class="mb-4">
            <i class="fas fa-tachometer-alt"></i> Admin Dashboard
        </h4>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-users"></i> Users management</h5>
            </div>
            <div class="card-body">
                <p></p>
                <a href="<?php echo Uri::base(); ?>admin/users" class="btn btn-primary">
                    <i class="fas fa-users"></i> Go to users management
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-file-alt"></i> Posts management</h5>
            </div>
            <div class="card-body">
                <p></p>
                <a href="<?php echo Uri::base(); ?>admin/posts" class="btn btn-success">
                    <i class="fas fa-file-alt"></i> Go to posts management
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-comments"></i> Comments management</h5>
            </div>
            <div class="card-body">
                <p></p>
                <a href="<?php echo Uri::base(); ?>admin/comments" class="btn btn-info">
                    <i class="fas fa-comments"></i> Go to comments management
                </a>
            </div>
        </div>
    </div>
</div>