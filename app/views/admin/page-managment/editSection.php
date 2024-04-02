<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<div class="container my-5">
    <form method="POST" action="/sectionEdit/?section_id=<?php echo urlencode($sectionID); ?>"
        enctype="multipart/form-data">
        <input type="hidden" name="section_id" value="<?php echo $sectionID; ?>">

        <? include __DIR__ . '/../components/editTitleSectionType.php' ?>

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

        <?php if ($imageFilePath !== null): ?>
            <div class="mb-3">
                <label for="formFile" class="form-label">Current Image</label>
                <div class="mb-3">
                    <img src="/img/uploads/<?php echo htmlspecialchars($imageFilePath); ?>" class="img-fluid img-thumbnail"
                        alt="Current Image">
                </div>
                <input class="form-control" type="file" id="formFile" name="newImage">
                <button type="submit" name="resetImage" value="1" class="btn btn-warning mt-2">Reset to Default
                    Image</button>
            </div>
        <?php endif; ?>

        <? include __DIR__ . '/../components/editCarouselItems.php' ?>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../../general_views/footer.php'; ?>