<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Darumadrop+One&display=swap" rel="stylesheet">
    <title>HAARLEM FESTIVALS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/overview.css">
    <link rel="stylesheet" href="/css/footer.css">


</head>
<body>
<main>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/../img/logo.png" alt="Logo" height="70">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0"> <!-- Changed here, from me-auto to ms-auto -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <img src="/../img/dutch.png" alt="NL" style="width: 20px;"> NL
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/">Homepage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">My Program</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Festivals
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Music</a></li>
                            <li><a class="dropdown-item" href="#">Yummy!</a></li>
                            <li><a class="dropdown-item" href="/history/overview">Strolling Through History</a></li>
                            <li><a class="dropdown-item" href="#">Art in the Open</a></li> <!-- Added fourth item -->
                        </ul>
                    </li>
                </ul>
                <?php
                  if (isset($_SESSION['role'])) {
                    $role = $_SESSION['role'];
                   if ($role == 'customer') {
                        echo ' <button class="btn btn-outline-success ms-2" type="button" onclick="location.href=\'/account\'">Account</button> ';
                        echo ' <button class="btn btn-danger ms-2" type="button" onclick="confirmLogout()">Logout</button> ';
                    } else {
                        echo ' <button class="btn btn-outline-success ms-2" type="button" onclick="location.href=\'/login\'">Login</button> ';
                        echo ' <button class="btn btn btn-dark ms-2" type="button" onclick="location.href=\'register\'">Register</button> ';
                    }
                } else {
                    echo ' <button class="btn btn-outline-success ms-2" type="button" onclick="location.href=\'/login\'">Login</button> ';
                    echo ' <button class="btn btn btn-dark ms-2" type="button" onclick="location.href=\'/register\'">Register</button> ';
                }
                ?>
            </div>
        </div>
    </nav>
    <div class="container">
        <!-- Content goes here -->
    </div>
</main>

<script type="text/javascript">
    function confirmLogout() {
        var logout = confirm("Are you sure you want to log out?");
        if (logout) {
            window.location.href = '/logout'; 
        }
    }
</script>