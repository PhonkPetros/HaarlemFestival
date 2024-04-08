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
    <a class="btn btn-primary btn-export">Export .xls</a>
    
    <div class="table-container scrollable-table-container" style="overflow-y: auto;
    max-height: 300px;">
        <table class="table">
            <thead>
                <tr>
                <th scope="col"> </th>
                <th scope="col">order ID</th>
                <th scope="col">Date</th>
                <th scope="col">Username</th>
            
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ordersContent as $order): ?>
                    <tr>
                        <td><input type="checkbox" name="checkbox" data-orderid="<?php echo $order['order_item_id'] ?>"></td>
                        <th scope="row"><?php echo $order['order_item_id'] ?></th>
                        <td><?php echo $order['date'] ?></td>
                        <td><?php echo $order['username'] ?></td>
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
<?php include __DIR__ . '/../../general_views/footer.php'; ?>