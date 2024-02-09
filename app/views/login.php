<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body class="bg-danger p-5 text-white ">
<div class="container ">
    <div class="d-flex flex-column justify-content-center align-items-center " style="min-height: 100vh;">
        <h1>Hello, welcome.</h1>
        <br>
        <h2>Please Login</h2>
        <br>
        <form method="POST" action="/login">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1" required>
                </div>
                <div class="mb-3">
                    <span onclick="location.href='password-reset'" style="cursor:pointer;">Forgot Password?</span>
                </div>
                <button type="submit" class="btn btn-light">Login</button>
                <button type="button" class="btn btn-dark" onclick="location.href='register'">Register</button>
            </form>
            <p><?php echo isset($loginError) ? htmlspecialchars($loginError) : ""; ?></p>
      
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>

