<?php $title = 'Chỉnh sửa bài viết'; ?>

<div class="row">
    <div class="col-12">
        <h1 class="mb-4">
            <i class="fas fa-edit"></i> Edit post
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-edit"></i> Post information</h5>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo Uri::base(); ?>author/post_edit/<?php echo $post->id; ?>" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title *</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $post->title; ?>" required>
                    </div>
                    
                    <!-- Thumbnail Upload Section -->
                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Thumbnail Image</label>
                        <div class="thumbnail-upload-container">
                            <div class="thumbnail-preview" id="thumbnailPreview">
                                <?php if ($post->featured_image): ?>
                                    <img src="<?php echo Uri::base() . 'assets/uploads/' . $post->featured_image; ?>" alt="Current thumbnail">
                                    <div class="thumbnail-overlay">
                                        <i class="fas fa-edit"></i>
                                        <span>Click to change image</span>
                                    </div>
                                <?php else: ?>
                                    <div class="thumbnail-placeholder">
                                        <i class="fas fa-image"></i>
                                        <span>Click to upload image</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <input type="file" class="form-control" id="featured_image" name="featured_image" 
                                   accept="image/*" style="display: none;">
                            <div class="thumbnail-upload-info">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    Recommended size: 800x400px. Max file size: 2MB. 
                                    Supported formats: JPG, PNG, GIF
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Summary</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3" placeholder="Tóm tắt ngắn gọn về bài viết..."><?php echo $post->excerpt; ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Content *</label>
                        <textarea class="form-control" id="content" name="content" rows="15" required placeholder="Viết nội dung bài viết của bạn..."><?php echo $post->content; ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="draft" <?php echo $post->status == 'draft' ? 'selected' : ''; ?>>Draft</option>
                            <option value="published" <?php echo $post->status == 'published' ? 'selected' : ''; ?>>Publish</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo Uri::base(); ?>author/posts" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>