<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <? include __DIR__ . "/../views/general_views/favicondata.php" ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-danger p-5 text-white">
<div class="container">
    <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
        <h2>Please Register</h2>
        <br>
        <form method="post" action="/register">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="mb-3">
                <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
            </div>
            <button type="submit" class="btn btn-light">Register</button>
            <button type="button" class="btn btn-dark" onclick="location.href='/login'">Login</button>
            <button type="button" class="btn btn-primary" onclick="location.href='/?pageid=1'">Home</button>
        </form>
        <br>
        <br>
        <?php if (!empty($registrationStatus)) : ?>
            <div class="alert alert-info">
                <?php echo $registrationStatus; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-2C9a4f1e1e3c3fgbbH4s3Y7LHOTqP9ZQ8g+6A5V1WxJqQ9r0TKx07FQKu5nKvCZ/p"
        crossorigin="anonymous"></script>
</body>
</html>
