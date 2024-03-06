<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<div class="container my-3">
    <h2>Existing Navigation Preview</h2>
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="/../img/logo.png" alt="Logo" height="70">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdownPreview" aria-controls="navbarNavDropdownPreview"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdownPreview">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php foreach ($existingNavigation as $page): ?>
                        <?php if ($page->getPageID() === 1): ?>
                            <li class="nav-item">
                                <a class="nav-link fw-bold">
                                    <?php echo htmlspecialchars($page->getPageName()); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <li class="nav-item">
                        <a class="nav-link fw-bold">My Program</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Festivals
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <?php foreach ($existingNavigation as $page): ?>
                                <?php if ($page->getPageID() != 1): ?>
                                    <li><a class="dropdown-item">
                                            <?php echo htmlspecialchars($page->getPageName()); ?>
                                        </a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

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

<?php include __DIR__ . '/../../general_views/footer.php'; ?>
