

<div class="row">
    <div class="col-12">
        <h3 class="mb-4">
            <i class="fas fa-blog"></i> Blog
        </h3>
    </div>
</div>

<!-- Search Form -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="search-form">
            <div class="input-group">
                <input type="text" 
                       class="form-control" 
                       id="searchInput"
                       value="<?php echo htmlspecialchars($search); ?>"
                       title="Using Ctrl+K to focus, Esc to delete search">
                <button class="btn btn-primary" type="button" id="searchBtn">
                    <i class="fas fa-search"></i> Search
                </button>
                <?php if (!empty($search)): ?>
                    <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                        <i class="fas fa-times"></i> Remove keyword
                    </button>
                <?php endif; ?>
            </div>
            <div class="search-loading mt-2" style="display: none;">
                <div class="d-flex align-items-center">
                    <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <small class="text-muted">Searching...</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search Results Alert -->
<div class="row mb-3" id="searchResultsAlert" style="display: none;">
    <div class="col-12">
        <div class="alert alert-info search-results-alert">
            <i class="fas fa-search"></i> 
            Result for: <strong id="searchTerm"></strong>
            <span class="badge bg-primary ms-2" id="searchCount">0 posts</span>
        </div>
    </div>
</div>

<!-- Posts Container -->
<div id="postsContainer">
    <?php if (empty($posts)): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <?php if (!empty($search)): ?>
                        <i class="fas fa-search"></i> Not found the post matching with keyword: <strong>"<?php echo htmlspecialchars($search); ?>"</strong>
                        <br><a href="<?php echo Uri::base(); ?>blog" class="btn btn-primary btn-sm mt-2">View all</a>
                    <?php else: ?>
                        <i class="fas fa-info-circle"></i> Empty post.
                        <?php if (Auth::check() && Auth::get_user()->group_id == ROLE_AUTHOR): ?>
                            <a href="<?php echo Uri::base(); ?>author/post_create" class="btn btn-primary btn-sm ms-2">Create the first post</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row" id="postsGrid">
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
</div>