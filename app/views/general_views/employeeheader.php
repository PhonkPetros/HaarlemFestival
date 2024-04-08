<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner / Reader</title>
    <link rel="stylesheet" href="style.css">
    <? include __DIR__ . "/favicondata.php" ?>
    <link href="https://fonts.googleapis.com/css2?family=Darumadrop+One&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/employeeview.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <main>
        <div class="bg-light">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="">
                        <img src="/../img/logo.png" alt="Logo" height="70">
                    </a>
                    <?php
                    if (isset($_SESSION['role'])) {
                        switch ($_SESSION['role']) {
                            case 'employee':
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
            </nav>
        </div>
    </main>

    
<script src="/js/logout.js"></script>