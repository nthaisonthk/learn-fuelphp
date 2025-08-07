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