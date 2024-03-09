<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<h1>Edit
    <?php echo htmlspecialchars($pageDetails->getName()); ?>
</h1>

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
                            <td>
                                <?php echo htmlspecialchars($section->getSectionId()); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($section->getTitle()); ?>
                            </td>
                            <td>
                                <a href="/sectionEdit/?section_id=<?php echo urlencode($section->getSectionId()); ?>"
                                    class="btn btn-primary btn-sm">Edit</a>
                                <!-- Change to a form for delete -->
                                <form action="/sectionDelete" method="post"
                                    onsubmit="return confirm('Are you sure you want to delete this section?');">
                                    <input type="hidden" name="section_id"
                                        value="<?php echo htmlspecialchars($section->getSectionId()); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
            <a href="/admin/page-management/editfestival" class="btn btn-danger" style="margin-bottom: 20px">Go Back</a>
        </div>
    <?php else: ?>
        <p>No sections found for this page.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../../general_views/footer.php'; ?>