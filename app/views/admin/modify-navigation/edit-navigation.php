<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>
<? include __DIR__ . '/../components/navigationPreview.php' ?>

<div class="container my-3 p-4 bg-light rounded">
    <h2>Modify Navigation</h2>
    <form action="/edit-navigation/modified" method="POST">
        <?php foreach ($allPages as $page): ?>
            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input" id="page_<?php echo $page->getId(); ?>" name="pages[]"
                    value="<?php echo $page->getId(); ?>" <?php echo in_array($page->getId(), $existingPageIds) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="page_<?php echo $page->getId(); ?>">
                    <?php echo htmlspecialchars($page->getName()); ?>
                </label>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Update Navigation</button>
    </form>

</div>
<div class="container">
    <a href="/admin/page-management/editfestival" class="btn btn-danger" style="margin-bottom: 20px">Go Back</a>
</div>



<?php include __DIR__ . '/../../general_views/footer.php'; ?>