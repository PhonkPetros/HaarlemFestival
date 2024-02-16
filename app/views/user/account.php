<?php include __DIR__ . '/../general_views/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account Details</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            max-width: 600px;
            width: 100%;
            margin-top: 40px; 
            border: 1px solid #ccc;
            border-radius: 8px;
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
            box-sizing: border-box;
        }
        .form-container input[type="submit"] {
            font-size: 1.2em;
            margin-bottom: 15px;
            width: 100%;
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
        <form id="updateAccountForm" method="POST" action="/account">
            <div style="margin-bottom: 10px;">
                <input type="email" class="input-lg form-control" name="updateEmail" id="email" placeholder="Email" autocomplete="off">
                <button class="update-button btn btn-primary" type="submit" name="updateEmailBtn">Update Email</button>
            </div>
            <div style="margin-bottom: 10px;">
                <input type="text" class="input-lg form-control" name="updateUsername" id="username" placeholder="Username" autocomplete="off">
                <button class="update-button btn btn-primary" type="submit" name="updateUsernameBtn">Update Username</button>
            </div>
            <div style="margin-bottom: 15px;">
                <input type="password" class="input-lg form-control" name="oldPassword" id="password1" placeholder="Password" autocomplete="off">
            </div>
            <div style="margin-bottom: 15px;">
                <input type="password" class="input-lg form-control" name="newPassword" id="password2" placeholder="New Password" autocomplete="off">
            </div>
            <button type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg" name="updatePasswordBtn">Update Password</button>
        </form>
    </div>
</div>
</body>
</html>
