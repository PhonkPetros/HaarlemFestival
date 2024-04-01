<div class="container mt-4 item-container">
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col-auto">
            <h3 style="text-decoration: underline;">My Cart & Reserved Tickets</h3>
        </div>
    </div>
    
    <!-- Shopping Cart Tickets -->
    <div class="ticket-row">
        <?php foreach ($structuredTickets as $eventId => $eventData): ?>
            <?php foreach ($eventData['tickets'] as $ticket): ?>
                <div class="ticket-container" id="ticket-container-<?= htmlspecialchars($ticket['ticketId']) ?>"
                    style="background-image: url('<?php echo htmlspecialchars($eventData['image']) ?: 'path/to/your/default-image.jpg'; ?>');">

                    <div class="ticket-details">
                        <h5 class="ticket-title">
                            <?php echo htmlspecialchars($eventData['event_name']); ?>
                        </h5>
                        <p class="ticket-info" style="font-size: 19px;">
                            Location: <?php echo htmlspecialchars($ticket['ticketLocation']); ?><br>
                            Date: <?php echo htmlspecialchars($ticket['ticketDate']); ?><br>
                            Start Time: <?php echo htmlspecialchars($ticket['ticketTime']); ?><br>
                            End Time: <?php echo htmlspecialchars($ticket['ticketEndTime']); ?><br>
                            Price: $<span id="total-price-<?= htmlspecialchars($ticket['ticketId']) ?>">
                                <?= htmlspecialchars($ticket['totalPrice']); ?>
                            </span>
                        </p>
                        <div class="ticket-controls">
                            <button onclick="modifyItemQuantity('<?= htmlspecialchars($ticket['ticketId']) ?>', '<?= htmlspecialchars($eventId) ?>', -1)">-</button>
                            <span class="quantity" id="quantity-<?= htmlspecialchars($ticket['ticketId']) ?>">
                                <?= htmlspecialchars($ticket['quantity']) ?>
                            </span>
                            <button onclick="modifyItemQuantity('<?= htmlspecialchars($ticket['ticketId']) ?>', '<?= htmlspecialchars($eventId) ?>', 1)">+</button>
                        </div>
                        <button class="remove-btn" onclick="deleteItemFromCart('<?= htmlspecialchars($ticket['ticketId']) ?>', '<?= htmlspecialchars($eventId) ?>')">Remove</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?> 
    </div>
    <div class="ticket-row">
            <?php foreach ($reservedTickets as $ticket): ?>
                <div class="ticket-container" 
                    id="ticket-container-reserved-<?= htmlspecialchars($ticket->getTicketId()) ?>"
                    style="background-color: #f0f0f0; padding: 10px; margin-bottom: 10px; border-radius: 5px;"
                    data-price="<?= htmlspecialchars($ticket->getPrice()) ?>"
                    data-quantity="<?= htmlspecialchars($ticket->getQuantity()) ?>">

                    <div class="ticket-details">
                        <p class="ticket-info" style="font-size: 19px;">
                            State: <?= htmlspecialchars($ticket->getState()); ?><br>
                            Date: <?= htmlspecialchars($ticket->getTicketDate()); ?><br>
                            Time: <?= htmlspecialchars($ticket->getTicketTime()); ?><br>
                            Quantity: <?= htmlspecialchars($ticket->getQuantity()); ?><br>
                            Price: €<?= htmlspecialchars($ticket->getPrice()); ?><br>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php if (empty($structuredTickets) && empty($reservedTickets)): ?>
        <div style="justify-content: center; text-align: center; color: black;">
            <h2>No Tickets Currently In Basket or Reserved</h2>
        </div>
    <?php else: ?>
        <div class="row justify-content-end" style="border-top: 1px solid black; padding-top: 10px; margin-top: 20px">
            <div class="col-auto">
                <div>
                    <h2>Total with VAT 21%: €<span id="total-cart-price">0.00</span></h2>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center" style="padding-top: 20px;">
            <a href="/my-program/payment" class="btn btn-success" style="width: 100%;"><h4>Pay Now</h4></a>
        </div>
    <?php endif; ?>
</div>

<script>
function calculateTotal() {
    let totalPrice = 0;
    const vatRate = 0.21;

    document.querySelectorAll('.ticket-container').forEach(container => {
    console.log(container.dataset.price, container.dataset.quantity); // Debugging line
    const price = parseFloat(container.dataset.price); 
    const quantity = parseInt(container.dataset.quantity); 
        if (!isNaN(price) && !isNaN(quantity)) { // Check if both values are numbers
            totalPrice += price * quantity;
        }
    });


    const totalPriceWithVAT = totalPrice + (totalPrice * vatRate);

    document.getElementById('total-cart-price').textContent = totalPriceWithVAT.toFixed(2);
}

document.addEventListener('DOMContentLoaded', calculateTotal);

document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', calculateTotal);
});
</script>

