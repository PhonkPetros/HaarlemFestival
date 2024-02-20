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
    <link rel="stylesheet" href="/css/manage-users.css">
    <link rel="stylesheet" href="/css/editDetailsHistory.css">
 


</head>
<body>
<main>
<nav class="navbar navbar-expand-lg navbar-secondary bg-secondary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">HAARLEM FESTIVALS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item">
            <a class="nav-link" href="/admin/manage-users">Manage Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/admin/managefestival">Manage Festival</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/admin/editfestival">Edit Festival</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/admin/orders">Orders</a>
        </li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-danger" type="button" onclick="confirmLogout()">Logout</button>
                </form>
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

