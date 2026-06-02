<?php
function render_image_picker($field_name, $current_value = '', $label = 'IMAGE') {
    $preview_src = '';
    if (!empty($current_value)) {
        $path = strpos($current_value, 'img/') === 0 ? '../' . $current_value : '../img/' . $current_value;
        $preview_src = htmlspecialchars($path);
    }
    $current_val_esc = htmlspecialchars($current_value);
    $uid = 'picker_' . $field_name . '_' . uniqid();
?>
<div class="form-group img-picker-group" id="<?= $uid ?>">
    <label><?= htmlspecialchars($label) ?></label>
    <input type="hidden" name="<?= htmlspecialchars($field_name) ?>" class="img-hidden-input" value="<?= $current_val_esc ?>">

    <div class="img-picker-box">
        <!-- Preview area -->
        <div class="img-preview-wrap">
            <?php if ($preview_src): ?>
                <img class="img-preview" src="<?= $preview_src ?>" alt="Current image">
            <?php else: ?>
                <div class="img-preview-placeholder">
                    <span>🖼️</span>
                    <p>No image selected</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="img-picker-controls">
            <?php if ($current_val_esc): ?>
                <p class="img-current-name">📎 <?= $current_val_esc ?></p>
            <?php endif; ?>
            <label class="btn-bat success img-upload-btn" style="cursor:pointer;display:inline-flex;align-items:center;gap:0.4rem;">
                📁 CHOOSE FILE
                <input type="file" accept="image/*" class="img-file-input" style="display:none;">
            </label>
            <div class="img-upload-status" style="margin-top:0.5rem;font-size:0.8rem;display:none;"></div>
        </div>
    </div>
</div>

<script>
(function() {
    var wrap   = document.getElementById('<?= $uid ?>');
    var fileIn = wrap.querySelector('.img-file-input');
    var hidden = wrap.querySelector('.img-hidden-input');
    var status = wrap.querySelector('.img-upload-status');
    var previewWrap = wrap.querySelector('.img-preview-wrap');

    fileIn.addEventListener('change', function() {
        var file = fileIn.files[0];
        if (!file) return;

        var reader = new FileReader();
        reader.onload = function(e) {
            previewWrap.innerHTML = '<img class="img-preview" src="' + e.target.result + '" alt="Preview">';
        };
        reader.readAsDataURL(file);

        status.style.display = 'block';
        status.style.color = '#fdff00';
        status.textContent = '⏳ Uploading...';

        var fd = new FormData();
        fd.append('image', file);

        fetch('upload_image.php', { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.success) {
                    hidden.value = data.filename;
                    status.style.color = '#44ff88';
                    status.textContent = '✔ Uploaded: ' + data.filename;
                    // Update current name label
                    var nameEl = wrap.querySelector('.img-current-name');
                    if (nameEl) nameEl.textContent = '📎 ' + data.filename;
                    else {
                        var p = document.createElement('p');
                        p.className = 'img-current-name';
                        p.textContent = '📎 ' + data.filename;
                        wrap.querySelector('.img-picker-controls').insertBefore(p, wrap.querySelector('.img-upload-btn'));
                    }
                } else {
                    status.style.color = '#ff4444';
                    status.textContent = '✖ ' + (data.error || 'Upload failed');
                }
            })
            .catch(function() {
                status.style.color = '#ff4444';
                status.textContent = '✖ Network error during upload';
            });
    });
})();
</script>
<?php } ?>
