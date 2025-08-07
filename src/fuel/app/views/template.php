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

    <link rel="stylesheet" href="<?php Uri::base() ?>assets/css/default.css">
    <style>
        .navbar-brand { font-weight: bold; }
        .footer { margin-top: 50px; padding: 20px 0; background-color: #f8f9fa; }
        .post-card { transition: transform 0.2s; }
        .post-card:hover { transform: translateY(-5px); }
        .comment-section { margin-top: 30px; }
        .comment-item { border-left: 3px solid #007bff; padding-left: 15px; margin-bottom: 15px; }
        .admin-stats { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/trumbowyg.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#content').trumbowyg();
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
                                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                    Management
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo Uri::base(); ?>admin/users">User Management</a></li>
                                    <li><a class="dropdown-item" href="<?php echo Uri::base(); ?>admin/posts">Posts Management</a></li>
                                    <li><a class="dropdown-item" href="<?php echo Uri::base(); ?>admin/comments">Comments Management</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if (Auth::check()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?php echo Auth::get_user()->username; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo Uri::base(); ?>dashboard">Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
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
    <script src="<?php Uri::base() ?>assets/js/post.js ?>"></script>
</body>
</html>
