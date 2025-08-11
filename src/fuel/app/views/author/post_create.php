<div class="row">
    <div class="col-12">
        <h4 class="mb-4">
            <i class="fas fa-plus"></i> Create new post
        </h4>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-edit"></i> Post information</h5>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo Uri::base(); ?>author/post_create" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title *</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    
                    <!-- Thumbnail Upload Section -->
                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Thumbnail Image</label>
                        <div class="thumbnail-upload-container">
                            <div class="thumbnail-preview" id="thumbnailPreview">
                                <div class="thumbnail-placeholder">
                                    <i class="fas fa-image"></i>
                                    <span>Click to upload image</span>
                                </div>
                            </div>
                            <input type="file" class="form-control" id="featured_image" name="featured_image" 
                                   accept="image/*">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Excerpt</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3" placeholder="Brief summary of the post..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Content *</label>
                        <textarea class="form-control" id="content" name="content" rows="15" required placeholder="All content of the post..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="draft">Draft</option>
                            <option value="published">Publish</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo Uri::base(); ?>author/posts" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>