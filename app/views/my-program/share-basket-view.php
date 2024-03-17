<div class="container mt-4">
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col-auto">
            
        </div>
    </div>
    <div class="ticket-row">
        <?php if (empty ($structuredTickets)): ?>
            <div style="justify-content: center; text-align: center; color: black;">
                <h2>No Tickets Currently In Basket</h2>
            </div>
        <?php endif; ?>
        <?php foreach ($structuredTickets as $eventId => $eventData): ?>
            <?php foreach ($eventData['tickets'] as $ticket): ?>
                <div class="ticket-container" id="ticket-container-<?= $ticket['ticketId'] ?>"
                    style="background-image: url('<?php echo $eventData['image']; ?>'); height: 300px !important;">
                    <div class="ticket-details" style="height: 350px">
                        <h5 class="ticket-title" style="margin: 30px">
                            <?php echo htmlspecialchars($eventData['event_name']); ?>
                        </h5>
                        <p class="ticket-info">
                            Location:
                            <?php echo htmlspecialchars($eventData['location']); ?><br><br>
                            Date:
                            <?php echo htmlspecialchars($ticket['ticketDate']); ?><br><br>
                            Time:
                            <?php echo htmlspecialchars($ticket['ticketTime']); ?><br><br>
                            Price: $<span id="total-price-<?= $ticket['ticketId'] ?>">
                                <?= htmlspecialchars($ticket['totalPrice']); ?>
                            </span>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <div class="row justify-content-end" style="border-top: 1px solid black; padding-top: 10px; margin-top: 20px">
        <div class="col-auto">
        </div>
        <div class="col-auto">
            <div>
                <h2>Total:</h2>
                <h3>$<span id="total-cart-price">0.00</span></h3>
            </div>
        </div>
    </div>
</div>

<script src="/js/modifyBasket.js"></script>

<?php require_once __DIR__ . '/../general_views/footer.php'; ?>