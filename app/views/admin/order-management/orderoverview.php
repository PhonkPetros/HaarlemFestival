<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<script>
    const ordersContent = [];
    <?php foreach ($ordersContent as $order): ?>
        ordersContent.push(<?= json_encode($order) ?>);
    <?php endforeach; ?>
</script> 

<div class = container>
    <h1> Order Summary</h1>
    <h2> order summaries from all users</h2>
    <a class="btn btn-primary" href="/admin/order-overview/export">Export .xls</a>
    
    <div class = "table-container">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">order ID</th>
                <th scope="col">Date</th>
                <th scope="col">Username</th>
                <th scope="col">Events</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ordersContent as $order): ?>
                    <tr>
                        <th scope="row"><?php echo $order['order_item_id'] ?></th>
                        <td><?php echo $order['date'] ?></td>
                        <td><?php echo $order['username'] ?></td>
                        <td><?php echo $order['events'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>    
    </div>
</div>

<div id="orderDetailsModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>

            </div>
        </div>
    </div>
</div>

<script src="/js/orderoverview.js"></script>