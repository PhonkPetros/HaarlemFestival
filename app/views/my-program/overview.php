<?php
include __DIR__ . '/../general_views/header.php';
?>


<div class="container mt-4 myprogram-container">
    <h1>My Program</h1>
    <div class="row justify-content-between align-items-center mb-3 ">
        <div class="col-auto">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" onclick="generateAndShareLink()">Share My Program</button>
            <a id="shareLink" style="display: none;" onclick="copyToClipboard(event)">Copy Link</a>
        </div>
    </div>
    <? require_once __DIR__ . '/list-view.php'; ?>
    <? require_once __DIR__ . '/purchased-ticket.php'; ?>
</div>






<script src="/js/modifyBasket.js"></script>


<?php
include __DIR__ . '/../general_views/footer.php';
?>