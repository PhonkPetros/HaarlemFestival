<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>



<div class="container" style="margin-top: 20px;">
    <h1>Edit
        <?php echo htmlspecialchars($pageDetails->getName()); ?>
    </h1>
    <?php
    $disabledPages = [PAGE_ID_HOME, PAGE_ID_HISTORY, PAGE_ID_DANCE, PAGE_ID_JAZZ, PAGE_ID_YUMMY];
    $disableButton = in_array($pageDetails->getId(), $disabledPages);
    ?>
    <div class="d-flex justify-content-end mb-2">
        <button id="addNewSectionBtn" class="btn btn-success" data-page-id="<?php echo $pageDetails->getId(); ?>" <?php if ($disableButton)
               echo 'disabled'; ?>>
            Add New Section
        </button>
    </div>
    <?php if (!empty($allSections)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Section Nr</th>
                        <th>Title</th>
                        <th>Section Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sectionCount = 1; ?>
                    <?php foreach ($allSections as $section): ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($sectionCount); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($section->getTitle()); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($section->getType()); ?>
                            </td>
                            <td>
                                <a href="/sectionEdit/?section_id=<?php echo urlencode($section->getSectionId()); ?>"
                                    class="btn btn-primary btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm delete-section-btn"
                                    data-section-id="<?php echo htmlspecialchars($section->getSectionId()); ?>">Delete</button>
                                <form id="deleteSection-<?php echo htmlspecialchars($section->getSectionId()); ?>"
                                    action="/sectionDelete" method="post" style="display: none;">
                                    <input type="hidden" name="section_id"
                                        value="<?php echo htmlspecialchars($section->getSectionId()); ?>">
                                </form>

                            </td>
                        </tr>
                        <?php $sectionCount++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="/admin/page-management/editfestival" class="btn btn-danger" style="margin-bottom: 20px">Go Back</a>
        </div>
    <?php else: ?>
        <p>No sections found for this page.</p>
    <?php endif; ?>
</div>



<script src="/js/add-new-section.js"></script>

<?php include __DIR__ . '/../../general_views/footer.php'; ?>