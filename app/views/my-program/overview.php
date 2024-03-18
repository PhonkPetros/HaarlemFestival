<?php
include __DIR__ . '/../general_views/header.php';
?>
<h1>My Program</h1>

<div class="container-fluid" style="width: 90%;
    height: 700px;
    background-color: rgba(255, 255, 255, 0.5);
    margin: auto;
    border-radius: 10px;
    padding-top: 10px;">
    <p>My Cart</p>
    <? require_once __DIR__ . '/list-view.php'; ?>
</div>




<script src="/js/modifyBasket.js"></script>


<?php
include __DIR__ . '/../general_views/footer.php';
?>