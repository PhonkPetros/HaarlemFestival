<body>
    <main>
        <?php if (isset($allPages) && is_array($allPages)): ?>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">
                        <img src="/../img/logo.png" alt="Logo" height="70">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <?php foreach ($allPages as $page): ?>
                                <?php if ($page->getPageID() == 1): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/?pageid=<?php echo urlencode($page->getPageID()); ?>">
                                            <?php echo htmlspecialchars($page->getPageName()); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <li class="nav-item">
                                        <a class="nav-link" href="#">My Program</a>
                                    </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Festivals
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <?php foreach ($allPages as $page): ?>
                                        <?php if ($page->getPageID() != 1): ?>
                                            <li><a class="dropdown-item"
                                                    href="/?pageid=<?php echo urlencode($page->getPageID()); ?>">
                                                    <?php echo htmlspecialchars($page->getPageName()); ?>
                                                </a></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                        <?php
                        if (isset($_SESSION['role'])) {
                            switch ($_SESSION['role']) {
                                case 'customer':
                                    echo '<button class="btn btn-outline-success ms-2" type="button" onclick="location.href=\'/account\'">Account</button>';
                                    echo '<button class="btn btn-danger ms-2" type="button" onclick="confirmLogout()">Logout</button>';
                                    break;
                                default:
                                    echo '<button class="btn btn-outline-success ms-2" type="button" onclick="location.href=\'/login\'">Login</button>';
                                    echo '<button class="btn btn-dark ms-2" type="button" onclick="location.href=\'/register\'">Register</button>';
                                    break;
                            }
                        } else {
                            echo '<button class="btn btn-outline-success ms-2" type="button" onclick="location.href=\'/login\'">Login</button>';
                            echo '<button class="btn btn-dark ms-2" type="button" onclick="location.href=\'/register\'">Register</button>';
                        }
                        ?>
                    </div>
                </div>
            </nav>
        <?php endif; ?>
        <div class="container">
        </div>
    </main>

    <script src="/js/logout.js"></script>
