<?php include __DIR__ . '/../general_views/adminheader.php'; ?>

<div class="content">
    <h1>Page Management</h1>
    <h3 style="margin: 30px;">Modify Page Content And Images | Create New Pages | Modify Navigation</h3>
    <div style="margin-bottom: 30px">
        <a href="/add-page>" class="btn btn-primary">Add New Page</a>
        <a href="/modify-navigation/edit-navigation"><button class="btn btn-secondary" type="button" id="navigationBtn" >Modify Navigation</button></a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Page ID</th>
                    <th>Page Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allPages as $page): ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($page->getId()); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($page->getName()); ?>
                        </td>
                        <td>
                            <a href="/edit-content/?id=<?php echo htmlspecialchars($page->getId()) ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="/delete-page/?id=<?php echo htmlspecialchars($page->getId()) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Page?');">Delete</a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../general_views/footer.php'; ?>