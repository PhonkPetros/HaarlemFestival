<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot your password?</title>
    <? include __DIR__ . "/favicondata.php" ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-danger p-5 text-white">
<a href="/" style="font-size: 24px; position: absolute; top: 20px; left: 20px; color: white;">← Go Home</a>
<div class="container">
    <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
        <h1>Forgot your password?</h1>
        <h2>reset password</h2>
        <form method="POST" action="/reset-password">
            <div class="mb-3">
                <label for="username" class="form-label">Enter your email</label>
                <input type="text" class="form-control" name="email" id="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Send me email</button>
    
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

