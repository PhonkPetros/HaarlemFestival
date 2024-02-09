<!DOCTYPE html>
<html lang="en">
<head>
    <title>HAARLEM FESTIVALS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<main>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./img/logo.png" alt="Logo" width="30" height="30">
                HAARLEM Festivals
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0"> 
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <img src="./img/dutch.png" alt="NL" style="width: 20px;"> NL
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Homepage</a>
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
                            <li><a class="dropdown-item" href="#">Strolling Through History</a></li>
                        </ul>
                    </li>
                </ul>
               
                <?php
                  if (isset($_SESSION['role'])) {
                    $role = $_SESSION['role'];
                    if ($role == 'admin') {
                        echo ' <button class="btn btn-outline-success ms-2" type="button" onclick="location.href=\'dashboard\'">Dashboard</button> ';
                        echo ' <button class="btn btn-danger ms-2" type="button" onclick="confirmLogout()">Logout</button> ';
                    } elseif ($role == 'customer') {
                        echo ' <button class="btn btn-outline-success ms-2" type="button" onclick="location.href=\'Account\'">Account</button> ';
                        echo ' <button class="btn btn-danger ms-2" type="button" onclick="confirmLogout()">Logout</button> ';
                    } else {
                        echo ' <button class="btn btn-outline-success ms-2" type="button" onclick="location.href=\'login\'">Login</button> ';
                    }
                } else {
                    echo ' <button class="btn btn-outline-success ms-2" type="button" onclick="location.href=\'login\'">Login</button> ';
                }
                ?>
            </div>
        </div>
    </nav>
    <div class="container">
      
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-2C9a4f1e1e3c3fgbbH4s3Y7LHOTqP9ZQ8g+6A5V1WxJqQ9r0TKx07FQKu5nKvCZ/p" crossorigin="anonymous"></script>
</body>
</html>
