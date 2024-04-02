<?php include __DIR__ . '/../general_views/adminheader.php'; ?>

<div class="content">
    <h1>Page Management</h1>
    <h3 style="margin: 30px;">Modify Page Content And Images | Create New Pages | Modify Navigation</h3>
    <div style="margin-bottom: 30px">
        <button type="button" class="btn btn-success" id="openModalBtn">
            Add New Page
        </button>
        <a href="/modify-navigation/edit-navigation"><button class="btn btn-secondary" type="button"
                id="navigationBtn">Modify Navigation</button></a>
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
                            <a href="/edit-content/?id=<?php echo htmlspecialchars($page->getId()) ?>"
                                class="btn btn-primary btn-sm">Edit</a>
                            <form action="/delete-page" method="POST" class="delete-page-form">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($page->getId()); ?>">
                                <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>


<? include __DIR__ . '/components/addpagepopup.php' ?>
<script src="/js/edit-festival-modal-controls.js"></script>
<? include __DIR__ . '/components/feedbackpopups.php' ?>
<? include __DIR__ . '/../general_views/footer.php'; ?>