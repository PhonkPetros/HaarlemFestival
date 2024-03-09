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
                            <a href="/delete-page/?id=<?php echo htmlspecialchars($page->getId()) ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this Page?');">Delete</a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<div id="addPageModal"
    style="display: none; position: fixed; z-index: 999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
    <div
        style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h5 style="margin: 0;">Add New Page</h5>
            <button type="button" id="closeModalBtn"
                style="border: none; background-color: transparent; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <form action="/add-page" method="post">
            <div style="margin-top: 20px;">
                <label for="pageTitle">Page Title</label>
                <input type="text" id="pageTitle" name="pageTitle" required
                    style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div style="margin-top: 20px;">
                <label for="sectionAmount">Amount of Sections</label>
                <input type="number" id="sectionAmount" name="sectionAmount" min="1" max="10" required
                    style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
                <button type="button" id="closeModalFooterBtn"
                    style="padding: 8px 16px; background-color: #6c757d; color: white; border: none; cursor: pointer; margin-right: 10px;">Close</button>
                <button type="submit"
                    style="padding: 8px 16px; background-color: #007bff; color: white; border: none; cursor: pointer;">Save
                    changes</button>
            </div>
        </form>
    </div>
</div>

<? if (isset($_SESSION['error_message'])) {
    echo "<script>alert('" . $_SESSION['error_message'] . "') </script>";
    unset($_SESSION['error_message']); 
}

if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "') </script>";
    unset($_SESSION['success_message']); 
} ?>

<script>

    var modal = document.getElementById('addPageModal');

    var openModalBtn = document.getElementById('openModalBtn');

    var closeModalBtn = document.getElementById('closeModalBtn');
    var closeModalFooterBtn = document.getElementById('closeModalFooterBtn');

    openModalBtn.addEventListener('click', function () {
        modal.style.display = 'block';
    });

    closeModalBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    closeModalFooterBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function (e) {
        if (e.target == modal) {
            modal.style.display = 'none';
        }
    });
</script>

<?php include __DIR__ . '/../general_views/footer.php'; ?>