<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Blog'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/ui/trumbowyg.min.css">
    <link rel="stylesheet" href="<?php Uri::base() ?>assets/css/template.css">
    <link rel="stylesheet" href="<?php Uri::base() ?>assets/css/default.css">
    <script src="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/trumbowyg.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#content').trumbowyg();

            // AJAX Search functionality
            let searchTimeout;
            const searchInput = $('#searchInput');
            const searchBtn = $('#searchBtn');
            const clearSearchBtn = $('#clearSearch');
            const searchLoading = $('.search-loading');
            const searchResultsAlert = $('#searchResultsAlert');
            const postsContainer = $('#postsContainer');

            // Search on Enter key
            searchInput.keypress(function (e) {
                if (e.which === 13) { // Enter
                    e.preventDefault();
                    performSearch();
                }
            });

            // Search button click
            searchBtn.click(function () {
                performSearch();
            });

            // Clear search button click
            clearSearchBtn.click(function () {
                clearSearch();
            });

            // Real-time search with debouncing
            searchInput.on('input', function () {
                clearTimeout(searchTimeout);
                const query = $(this).val().trim();

                if (query.length >= 2) {
                    searchTimeout = setTimeout(function () {
                        performSearch();
                    }, 500); // 500ms delay
                } else if (query.length === 0) {
                    clearSearch();
                }
            });

            function performSearch() {
                const query = searchInput.val().trim();

                if (query.length === 0) {
                    clearSearch();
                    return;
                }

                // Show loading
                searchLoading.show();
                searchBtn.prop('disabled', true);

                // Make AJAX request
                $.ajax({
                    url: '<?php echo Uri::base(); ?>blog/search',
                    method: 'GET',
                    data: { search: query },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            displaySearchResults(response);
                        } else {
                            showError('Something wrong!');
                        }
                    },
                    error: function (xhr, status, error) {
                        showError('Not connect to server');
                        console.error('Search error:', error);
                    },
                    complete: function () {
                        searchLoading.hide();
                        searchBtn.prop('disabled', false);
                    }
                });
            }

            function displaySearchResults(response) {
                const posts = response.posts;
                const searchTerm = response.search;
                const total = response.total;

                // Update search results alert
                $('#searchTerm').text('"' + searchTerm + '"');
                $('#searchCount').text(total + ' posts');
                searchResultsAlert.show();

                // Update posts container
                if (total === 0) {
                    postsContainer.html(`
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-search"></i> Not found the post match with keyword: <strong>"${searchTerm}"</strong>
                                    <br><button class="btn btn-primary btn-sm mt-2" onclick="clearSearch()">View all</button>
                                </div>
                            </div>
                        </div>`);
                } else {
                    let postsHtml = '<div class="row" id="postsGrid">';

                    posts.forEach(function (post) {
                        const imageHtml = post.featured_image
                            ? `<img src="<?php echo Uri::base(); ?>assets/uploads/${post.featured_image}" class="card-img-top post-thumbnail-img" alt="${post.title}">`
                            : `<div class="post-thumbnail-placeholder"><i class="fas fa-image"></i><span>No Image</span></div>`;

                        const statusBadge = post.is_published
                            ? '<span class="badge bg-success">Published</span>'
                            : '<span class="badge bg-warning">Draft</span>';

                        postsHtml += `
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 post-card">
                                    <div class="post-thumbnail">
                                        ${imageHtml}
                                        <div class="post-status-badge">
                                            ${statusBadge}
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title post-title">${post.title}</h5>
                                        <p class="card-text text-muted post-meta">
                                            <small>
                                                <i class="fas fa-user"></i> ${post.author} |
                                                <i class="fas fa-calendar"></i> ${post.date}
                                            </small>
                                        </p>
                                        <p class="card-text post-excerpt">${post.excerpt}</p>
                                        <div class="mt-auto">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="${post.url}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i> Read post
                                                </a>
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-comments"></i> ${post.comments_count}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                    });

                    postsHtml += '</div>';
                    postsContainer.html(postsHtml);
                }

                // Update URL without page reload
                const newUrl = '<?php echo Uri::base(); ?>blog?search=' + encodeURIComponent(searchTerm);
                window.history.pushState({ search: searchTerm }, '', newUrl);
            }

            function clearSearch() {
                searchInput.val('');
                searchResultsAlert.hide();
                searchLoading.hide();
                searchBtn.prop('disabled', false);

                // Reload page to show all posts
                window.location.href = '<?php echo Uri::base(); ?>blog';
            }

            // Make clearSearch global for onclick handlers
            window.clearSearch = clearSearch;

            function showError(message) {
                postsContainer.html(`
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger text-center">
                                <i class="fas fa-exclamation-triangle"></i> ${message}
                                <br><button class="btn btn-primary btn-sm mt-2" onclick="location.reload()">Thử lại</button>
                            </div>
                        </div>
                    </div>
                `);
            }

            // Handle browser back/forward buttons
            window.onpopstate = function (event) {
                if (event.state && event.state.search) {
                    searchInput.val(event.state.search);
                    performSearch();
                } else {
                    clearSearch();
                }
            };
        });
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?php echo Uri::base(); ?>">
                <i class="fas fa-blog"></i> Blog
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo Uri::base(); ?>">Home page</a>
                    </li>
                    <?php if (Auth::check()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo Uri::base(); ?>dashboard">Dashboard</a>
                        </li>
                        <?php if (Auth::get_user()->group_id == ROLE_AUTHOR): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo Uri::base(); ?>author/posts">Posts Manage</a>
                            </li>
                        <?php endif; ?>
                        <?php if (Auth::get_user()->group_id == ROLE_ADMIN): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                                    data-bs-toggle="dropdown">
                                    Management
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo Uri::base(); ?>admin/users">User
                                            Management</a></li>
                                    <li><a class="dropdown-item" href="<?php echo Uri::base(); ?>admin/posts">Posts
                                            Management</a></li>
                                    <li><a class="dropdown-item" href="<?php echo Uri::base(); ?>admin/comments">Comments
                                            Management</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if (Auth::check()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?php echo Auth::get_user()->username; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo Uri::base(); ?>auth/logout">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo Uri::base(); ?>auth/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo Uri::base(); ?>auth/register">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <?php if (Session::get_flash('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo Session::get_flash('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (Session::get_flash('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo Session::get_flash('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php echo $content; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php Uri::base() ?>assets/js/post.js"></script>
</body>

</html>