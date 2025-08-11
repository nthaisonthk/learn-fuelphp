<?php $title = 'Chỉnh sửa bài viết'; ?>

<div class="row">
    <div class="col-12">
        <h1 class="mb-4">
            <i class="fas fa-edit"></i> Chỉnh sửa bài viết
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-edit"></i> Thông tin bài viết</h5>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo Uri::base(); ?>admin/post_edit/<?php echo $post->id; ?>" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề bài viết *</label>
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
                        <label for="excerpt" class="form-label">Tóm tắt</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3" placeholder="Tóm tắt ngắn gọn về bài viết..."><?php echo $post->excerpt; ?></textarea>
                        <div class="form-text">Tóm tắt sẽ hiển thị trong danh sách bài viết</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung bài viết *</label>
                        <textarea class="form-control" id="content" name="content" rows="15" required placeholder="Viết nội dung bài viết của bạn..."><?php echo $post->content; ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="draft" <?php echo $post->status == 'draft' ? 'selected' : ''; ?>>Bản nháp</option>
                            <option value="published" <?php echo $post->status == 'published' ? 'selected' : ''; ?>>Xuất bản</option>
                        </select>
                        <div class="form-text">Chọn "Bản nháp" để lưu và chỉnh sửa sau, hoặc "Xuất bản" để đăng ngay</div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo Uri::base(); ?>admin/posts" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.thumbnail-upload-container {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    background-color: #f8f9fa;
    transition: all 0.3s ease;
    cursor: pointer;
}

.thumbnail-upload-container:hover {
    border-color: #007bff;
    background-color: #f0f8ff;
}

.thumbnail-preview {
    width: 100%;
    height: 200px;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 15px;
    background-color: #fff;
    border: 1px solid #e9ecef;
    position: relative;
}

.thumbnail-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #6c757d;
}

.thumbnail-placeholder i {
    font-size: 3rem;
    margin-bottom: 10px;
    color: #dee2e6;
}

.thumbnail-placeholder span {
    font-size: 1rem;
    font-weight: 500;
}

.thumbnail-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.thumbnail-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.thumbnail-preview:hover .thumbnail-overlay {
    opacity: 1;
}

.thumbnail-overlay i {
    font-size: 2rem;
    margin-bottom: 10px;
}

.thumbnail-overlay span {
    font-size: 0.9rem;
    font-weight: 500;
}

.thumbnail-upload-info {
    margin-top: 10px;
}

.thumbnail-upload-info small {
    font-size: 0.85rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textarea
    const contentTextarea = document.getElementById('content');
    contentTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
    
    // Character counter for excerpt
    const excerptTextarea = document.getElementById('excerpt');
    excerptTextarea.addEventListener('input', function() {
        const maxLength = 200;
        const currentLength = this.value.length;
        const remaining = maxLength - currentLength;
        
        if (remaining < 0) {
            this.value = this.value.substring(0, maxLength);
        }
    });
    
    // Thumbnail upload functionality
    const thumbnailContainer = document.querySelector('.thumbnail-upload-container');
    const thumbnailInput = document.getElementById('featured_image');
    const thumbnailPreview = document.getElementById('thumbnailPreview');
    
    thumbnailContainer.addEventListener('click', function() {
        thumbnailInput.click();
    });
    
    thumbnailInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file.');
                return;
            }
            
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB.');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                thumbnailPreview.innerHTML = `<img src="${e.target.result}" alt="Thumbnail preview">`;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script> 