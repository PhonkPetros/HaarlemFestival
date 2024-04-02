<div class="container-wrapper">
    <div class="container-fluid" style="display: flex; justify-content: center; align-items: center;">
        <div class="form-container"
            style="max-width: 900px; width: 100%; margin-top: 40px; border: 1px solid #ccc; background-color: #F4F4F4; border-radius: 8px; padding: 20px;">
            <h1
                style="width: 100%; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                Update account details</h1>
            <p>Use the form below to update your credentials. You will receive a confirmation email after you click the
                submit button.</p>
            <form id="updateAccountForm" method="POST" action="/account" style="text-align: center;">
                <div style="margin-bottom: 10px;">
                    <input type="email" class="input-lg form-control" name="updateEmail" id="email" placeholder="Email"
                        autocomplete="off"
                        style="margin-bottom: 10px; width: calc(100% - 10px); box-sizing: border-box;">
                    <button class="update-button btn btn-primary" type="submit" name="updateEmailBtn"
                        style="margin-top: 5px; margin-bottom: 5px; width: calc(100% - 10px); box-sizing: border-box;">Update
                        Email</button>
                </div>
                <div style="margin-bottom: 10px;">
                    <input type="text" class="input-lg form-control" name="updateUsername" id="username"
                        placeholder="Username" autocomplete="off"
                        style="margin-bottom: 10px; width: calc(100% - 10px); box-sizing: border-box;">
                    <button class="update-button btn btn-primary" type="submit" name="updateUsernameBtn"
                        style="margin-top: 5px; margin-bottom: 5px; width: calc(100% - 10px); box-sizing: border-box;">Update
                        Username</button>
                </div>
                <div style="margin-bottom: 15px;">
                    <input type="password" class="input-lg form-control" name="oldPassword" id="password1"
                        placeholder="Password" autocomplete="off"
                        style="margin-bottom: 10px; width: calc(100% - 10px); box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 15px;">
                    <input type="password" class="input-lg form-control" name="newPassword" id="password2"
                        placeholder="New Password" autocomplete="off"
                        style="margin-bottom: 10px; width: calc(100% - 10px); box-sizing: border-box;">
                </div>
                <button type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg" name="updatePasswordBtn"
                    style="font-size: 1.2em; margin-bottom: 15px; width: 100%;">Update Password</button>
            </form>
        </div>
    </div>
    <br>
    <br>
</div>

<? include __DIR__ . '/checkingforresponse.php' ?>
<?
include __DIR__ . '/../general_views/footer.php';
?>