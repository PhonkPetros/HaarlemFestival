<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-danger p-5 text-white">
<div class="container">
    <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
        <h1> Write down your new password</h1>
        <form method="POST" action="/new-passwords">
            <input type="text" style="display: none;" name="token" value="<?php echo htmlspecialchars($_GET['token']) ?>" required>
            <div class="mb-3">
                <label for="newPassword" class="form-label">New Password</label>
                <input type="text" class="form-control" name="newPassword" id="newPassword" required>
            </div>
            <button type="submit" class="btn btn-dark">Set Password</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>
