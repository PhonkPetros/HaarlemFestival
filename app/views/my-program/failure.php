<div class="container-wrapper"><br><br><br><br><br><br></div>
<div class="container-wrapper">
    <div class="text-center">
        <div class="py-4">
            <h2 class="font-weight-bold my-3" style="color: #19405D;">Something Went Wrong When Paying For Your Order
            </h2>
            <h3>Please Contact The Admin</h3>
            <h4>Payment ID
                <? echo htmlspecialchars($_SESSION['payment_id']) ?>
            </h4>
        </div>
    </div>
</div>
<div class="container-wrapper"><br><br><br><br><br><br></div>

<?php
include __DIR__ . '/../general_views/footer.php';
?>