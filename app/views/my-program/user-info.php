<style>
    .input-shadow {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container mt-4 item-container">
    <form style="margin: 6px;">
        <div class="form-group mb-3" style="margin: 6px;">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="firstname">First name</label>
                    <input type="text" class="form-control input-shadow" id="firstname" name="firstname"
                        value="<?php echo htmlspecialchars($userInfo['firstName'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="lastname">Last name</label>
                    <input type="text" class="form-control input-shadow" id="lastname" name="lastname"
                        value="<?php echo htmlspecialchars($userInfo['lastName'] ?? ''); ?>">
                </div>
            </div>
        </div>
        <div class="form-group mb-3" style="margin: 6px;">
            <label for="phonenumber">Phone number</label>
            <input type="text" class="form-control input-shadow" id="phonenumber" name="phonenumber"
                value="<?php echo htmlspecialchars($userInfo['phoneNumber'] ?? ''); ?>">
        </div>
        <div class="form-group mb-3" style="margin: 6px;"> 
            <label for="emailaddress">Email-Address</label>
            <input type="email" class="form-control input-shadow" id="emailaddress" name="emailaddress"
                value="<?php echo htmlspecialchars($userInfo['email'] ?? ''); ?>">
        </div>
    </form>
</div>

<script src="/js/modifyBasket.js"></script>
