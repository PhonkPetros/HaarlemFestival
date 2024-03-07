<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4">
        <?php echo htmlspecialchars($sectionTitle); ?>
    </h1>
    <form method="POST" action="/sectionEdit/?section_id=<?php echo urlencode($sectionID) ?>"
        enctype="multipart/form-data">
        <input type="hidden" name="section_id" value="<?php echo $sectionID; ?>">

        <?php if ($editorContent !== null): ?>
            <div class="mb-3">
                <textarea id="editor" name="content"
                    class="form-control"><?php echo htmlspecialchars($editorContent); ?> <?php echo "<img src='/img/{$imageFilePath}'/>" ?></textarea>
                <script>
                    tinymce.init({
                        selector: '#editor',
                        height: 500,
                    });
                </script>
            </div>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                This section does not have editable content.
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

        <button type="submit" class="btn btn-primary" style="margin-bottom: 20px">Save Changes</button>
        <button type="button" class="btn btn-danger" style="margin-bottom: 20px"
            onclick="window.history.back();">Cancel</button>
    </form>
</div>

<?php include __DIR__ . '/../../general_views/footer.php'; ?>