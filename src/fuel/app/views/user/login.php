<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <?php echo Asset::css('bootstrap.css'); ?>
    <style>
        body { margin: 40px; }
        .login-form {
            max-width: 400px;
            margin: 60px auto;
            padding: 30px;
            border: 1px solid #eee;
            border-radius: 8px;
            background: #fafafa;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="login-form">
        <h2>Đăng nhập</h2>
        <?php if (Session::get_flash('error')): ?>
            <div class="alert alert-danger">
                <?php echo Session::get_flash('error'); ?>
            </div>
        <?php endif; ?>
        <?php if (Session::get_flash('success')): ?>
            <div class="alert alert-success">
                <?php echo Session::get_flash('success'); ?>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
        </form>
        <hr>
        <p>Bạn chưa có tài khoản? <a href="<?php echo Uri::create('user/register'); ?>">Đăng ký</a></p>
    </div>
</div>
</body>
</html>