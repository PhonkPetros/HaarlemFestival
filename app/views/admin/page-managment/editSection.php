<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4"><?php echo htmlspecialchars($sectionTitle); ?></h1>
    <form method="POST" action="/sectionEdit/?section_id=<?php echo urlencode($sectionID)?>">
        <input type="hidden" name="section_id" value="<?php echo $sectionID; ?>">
        
        <?php if ($editorContent !== null): ?>
            <div class="mb-3">
                <textarea id="editor" name="content" class="form-control"><?php echo htmlspecialchars($editorContent); ?></textarea>
                <script>
                    tinymce.init({
                        selector: '#editor',
                
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
                <label for="sectionImage" class="form-label">Current Image</label>
                <div class="mb-3">
                    <img id="sectionImage" src="/img/<?php echo htmlspecialchars($imageFilePath); ?>" alt="Section Image" class="img-thumbnail">
                </div>
                <input class="form-control" type="file" id="newImage" name="new_image">
            </div>
        <?php endif; ?>

        <?php if ($carouselItems !== null): ?>
            <div class="mb-3">
                <label class="form-label">Carousel Items</label>
                <div class="overflow-auto mb-3" style="max-height: 200px;">
                    <?php foreach ($carouselItems as $carouselItem): ?>
                        <div class="card mb-2">
                            <img src="/img/<?php echo htmlspecialchars($carouselItem); ?>" class="card-img-top" alt="...">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<?php include __DIR__ . '/../../general_views/footer.php'; ?>
