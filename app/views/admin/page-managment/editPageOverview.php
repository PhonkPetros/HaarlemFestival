<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<h1>Edit <?php echo htmlspecialchars($pageDetails->getName()); ?></h1>

<div class="container">
    <?php if (!empty($allSections)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Section ID</th>
                        <th>Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allSections as $section): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($section->getSectionId()); ?></td>
                            <td><?php echo htmlspecialchars($section->getTitle()); ?></td>
                            <td>
                                <a href="/sectionEdit/?section_id=<?php echo urlencode($section->getSectionId()); ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="/sectionDelete/?section_id=<?php echo urlencode($section->getSectionId()); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this section?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="button" class="btn btn-danger" style="margin-bottom: 20px"
            onclick="window.history.back();">Go Back</button>
        </div>
    <?php else: ?>
        <p>No sections found for this page.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../../general_views/footer.php'; ?>
