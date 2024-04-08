<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <? include __DIR__ . "/" ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-danger p-5 text-white">
<div class="container">
    <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
        <h1>Welcome Back!</h1>
        <h2>Please Login</h2>
        <form method="POST" action="/login">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-light">Login</button>
            <button type="button" class="btn btn-dark" onclick="location.href='register'">Register</button>
            <button type="button" class="btn btn-primary" onclick="location.href='/reset-password'">Forgot Password</button>
        </form>
        <?php if (isset($loginError)): ?>
            <br>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($loginError); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>
