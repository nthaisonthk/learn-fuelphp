

<div class="row">
    <div class="col-12">
        <h4 class="mb-4">
            <i class="fas fa-plus"></i> Tạo bài viết mới
        </h4>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-edit"></i> Thông tin bài viết</h5>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo Uri::base(); ?>author/post_create">
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề bài viết *</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Tóm tắt</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3" placeholder="Tóm tắt ngắn gọn về bài viết..."></textarea>
                        <div class="form-text">Tóm tắt sẽ hiển thị trong danh sách bài viết</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung bài viết *</label>
                        <textarea class="form-control" id="content" name="content" rows="15" required placeholder="Viết nội dung bài viết của bạn..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="draft">Bản nháp</option>
                            <option value="published">Xuất bản</option>
                        </select>
                        <div class="form-text">Chọn "Bản nháp" để lưu và chỉnh sửa sau, hoặc "Xuất bản" để đăng ngay</div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo Uri::base(); ?>author/posts" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Lưu bài viết
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
});
</script> 