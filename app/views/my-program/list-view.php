<div class="container mt-4">
    <div class="ticket-row">
        <?php if (empty ($structuredTickets)): ?>
            <div style="justify-content: center; text-align: center; color: black;">
                <h2>No Tickets Currently In Basket</h2>
            </div>
        <?php endif; ?>
        <?php foreach ($structuredTickets as $eventId => $eventData): ?>
            <?php foreach ($eventData['tickets'] as $ticket): ?>
                <div class="ticket-container" id="ticket-container-<?= $ticket['ticketId'] ?>"
                    style="background-image: url('<?php echo $eventData['image']; ?>');">
                    <div class="ticket-details">
                        <h5 class="ticket-title">
                            <?php echo htmlspecialchars($eventData['event_name']); ?>
                        </h5>
                        <p class="ticket-info">
                            Location:
                            <?php echo htmlspecialchars($eventData['location']); ?><br>
                            Date:
                            <?php echo htmlspecialchars($ticket['ticketDate']); ?><br>
                            Time:
                            <?php echo htmlspecialchars($ticket['ticketTime']); ?><br>
                            Price: $<span id="total-price-<?= $ticket['ticketId'] ?>">
                                <?= htmlspecialchars($ticket['totalPrice']); ?>
                            </span>
                        </p>
                        <div class="ticket-controls">
                            <button onclick="modifyItemQuantity('<?= $ticket['ticketId'] ?>', '<?= $eventId ?>', -1)">-</button>
                            <span class="quantity" id="quantity-<?= $ticket['ticketId'] ?>">
                                <?= htmlspecialchars($ticket['quantity']) ?>
                            </span>
                            <button onclick="modifyItemQuantity('<?= $ticket['ticketId'] ?>', '<?= $eventId ?>', 1)">+</button>
                        </div>
                        <button class="remove-btn"
                            onclick="deleteItemFromCart('<?= $ticket['ticketId'] ?>', '<?= $eventId ?>')">Remove</button>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>

    </div>
    <div>Total Cart Price: $<span id="total-cart-price">0.00</span></div>
</div>

<script src="/js/modifyBasket.js"></script>

<?php require_once __DIR__ . '/../general_views/footer.php'; ?>