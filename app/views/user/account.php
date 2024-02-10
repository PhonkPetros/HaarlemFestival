<?php include __DIR__ . '/../general_views/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account Details</title>
    <style>
        /* Custom CSS for centering and styling */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            max-width: 600px;
            width: 100%;
            margin-top: 40px; /* Add some distance from the header */
            border: 1px solid #ccc; /* Add a border */
            border-radius: 8px; /* Round the corners */
            padding: 20px;
        }
        .form-container form {
            text-align: center;
        }
        .form-container input[type="email"],
        .form-container input[type="text"],
        .form-container input[type="password"] {
            margin-bottom: 10px;
            width: calc(100% - 10px);
            box-sizing: border-box; /* Ensure the padding and border are included in the width */
        }
        .form-container input[type="submit"] {
            font-size: 1.2em;
            margin-bottom: 15px;
            width: 100%; /* Make the button the same width as the input fields */
        }
        .form-container h1 {
            width: 100%;
            text-align: center;
            white-space: nowrap; /* Prevent the title from breaking into multiple lines */
            overflow: hidden; /* Hide overflow content */
            text-overflow: ellipsis; /* Display an ellipsis (...) when text overflows */
        }
        .update-button {
            margin-top: 5px;
            margin-bottom: 5px;
            width: calc(100% - 10px);
            box-sizing: border-box; /* Ensure the padding and border are included in the width */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h1>Update account details</h1>
        <p>Use the form below to update your credentials. You will receive a confirmation email after you click the submit button.</p>
        <form method="post" id="passwordForm">
            <div style="margin-bottom: 10px;">
                <input type="email" class="input-lg form-control" name="email" id="email" placeholder="Email" autocomplete="off">
                <button class="update-button btn btn-primary">Update Email</button>
            </div>
            <div style="margin-bottom: 10px;">
                <input type="text" class="input-lg form-control" name="username" id="username" placeholder="Username" autocomplete="off">
                <button class="update-button btn btn-primary">Update Username</button>
            </div>
            <div style="margin-bottom: 15px;">
                <input type="password" class="input-lg form-control" name="password1" id="password1" placeholder="New Password" autocomplete="off">
            </div>
            <div style="margin-bottom: 15px;">
                <input type="password" class="input-lg form-control" name="password2" id="password2" placeholder="Confirm Password" autocomplete="off">
            </div>
            <input type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg" data-loading-text="Updating Password...." value="Update Password">
        </form>
    </div>
</div>
</body>
</html>
