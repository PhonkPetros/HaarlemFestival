<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<div class="container my-5">

    <form method="POST" action="/sectionEdit/?section_id=<?php echo urlencode($sectionID); ?>"
        enctype="multipart/form-data">
        <input type="hidden" name="section_id" value="<?php echo $sectionID; ?>">

        <div class="mb-3">
            <label for="sectionTitle" class="form-label">Section Title</label>
            <input type="text" class="form-control" id="sectionTitle" name="sectionTitle"
                value="<?php echo htmlspecialchars($sectionTitle); ?>" required>
        </div>

        <?php if ($editorContent !== null): ?>
            <div class="mb-3">
                <label for="editor" class="form-label">Content</label>
                <textarea id="editor" name="content"
                    class="form-control"><?php echo htmlspecialchars($editorContent); ?></textarea>
                <script>
                    tinymce.init({
                        selector: '#editor',
                        height: 300,
                        plugins: 'link image code',
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
            </div>
        <?php endif; ?>

        <?php if (!empty($carouselItems['carouselItems'])): ?>
            <div class="mb-3">
                <label class="form-label">Carousel Items</label>
                <div class="row g-3">
                    <?php foreach ($carouselItems['carouselItems'] as $index => $carouselItem): ?>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100">
                                <img src="/img/<?php echo htmlspecialchars($carouselItem); ?>" class="card-img-top" alt="Carousel Image" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <input type="file" name="carouselImage[<?php echo $index; ?>]" class="form-control mb-2">
                                    <button type="button" class="btn btn-danger w-100" onclick="removeCarouselItem(<?php echo $index; ?>);">Remove</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" id="deletedCarouselItems" name="deletedCarouselItems" value="">
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../../general_views/footer.php'; ?>