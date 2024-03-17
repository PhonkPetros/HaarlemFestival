<div class="container mt-4">
    <div class="ticket-row">
    <?php if (empty($structuredTickets)): ?>
        <div style="justify-content: center; text-align: center; color: black;">
            <h2>No Tickets Currently In Basket</h2>
        </div>
    <?php endif; ?>
        <?php foreach ($structuredTickets as $eventId => $eventData): ?>
            <?php foreach ($eventData['tickets'] as $ticket): ?>
                <div class="ticket-container" style="background-image: url('<?php echo $eventData['image']; ?>');">
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
                            Price: $
                            <?php echo htmlspecialchars($ticket['totalPrice']); ?>
                        </p>
                        <div class="ticket-controls">
                            <button
                                onclick="modifyItemQuantity('<?php echo $ticket['ticketId']; ?>', '<?php echo $eventId; ?>', -1)">-</button>
                            <span class="quantity">
                                <?php echo htmlspecialchars($ticket['quantity']); ?>
                            </span>
                            <button
                                onclick="modifyItemQuantity('<?php echo $ticket['ticketId']; ?>', '<?php echo $eventId; ?>', 1)">+</button>
                        </div>

                        <button class="remove-btn"
                            onclick="deleteItemFromCart('<?php echo $ticket['ticketId']; ?>', '<?php echo $eventId; ?>')">Remove</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>
<?php require_once __DIR__ . '/../general_views/footer.php'; ?>