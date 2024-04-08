<?php if ($editorContent !== null): ?>
            <div class="mb-3">
                <label for="editor" class="form-label">Content</label>
                <textarea id="editor" name="content"
                    class="form-control"><?php echo htmlspecialchars($editorContent); ?></textarea>
                <script>
                    tinymce.init({
                        selector: '#editor',
                        height: 300,
                        plugins: 'link code',
                        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | code'
                    });
                </script>
            </div>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                This section does not have editable content.
            </div>
        <?php endif; ?>