<div class="container mt-4 myprogram-container">
    <h1>My Program</h1>
    <div class="row justify-content-between align-items-center mb-3 ">
        <div class="col-auto">
        </div>
    </div>

    <? require_once __DIR__ . '/list-view.php'; ?>
    <? require_once __DIR__ . '/purchased-ticket.php'; ?>
    <? require_once __DIR__ . '/agenda-view.php'; ?>

</div>


<script>
var structuredOrderedItems = <?php echo json_encode($structuredOrderedItems); ?>;
</script>

<script src="/js/my-program-agenda.js"></script>
<script src="/js/modifyBasket.js"></script>

<?php
include __DIR__ . '/../general_views/footer.php';
?>