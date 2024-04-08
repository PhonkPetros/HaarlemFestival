<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<div class="container my-5">
    <form method="POST" action="/sectionEdit/?section_id=<?php echo urlencode($sectionID); ?>"
        enctype="multipart/form-data">
        <input type="hidden" name="section_id" value="<?php echo $sectionID; ?>">

        <? include __DIR__ . '/../components/editTitleSectionType.php' ?>
        <? include __DIR__ . '/../components/editTextItems.php' ?>
        <? include __DIR__ . '/../components/editImageItems.php' ?>
        <? include __DIR__ . '/../components/editCarouselItems.php' ?>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../../general_views/footer.php'; ?>