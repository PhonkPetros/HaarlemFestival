<div class="container mt-4 item-container">
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col-auto">
            <h3 style="text-decoration: underline;">My Cart & Reserved Tickets</h3>
        </div>
    </div>
    
    <div class="ticket-row">
        <?php $structuredTickets = isset($structuredTickets) && is_array($structuredTickets) ? $structuredTickets : []; ?>
        <?php foreach ($structuredTickets as $eventId => $eventData): ?>
            <?php foreach ($eventData['tickets'] as $ticket): ?>
                <div class="ticket-container" id="ticket-container-<?= htmlspecialchars($ticket['ticketId']) ?>"
                    style="background-image: url('<?php echo htmlspecialchars($eventData['image'] ?? 'img/default-image.jpg'); ?>');">
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>

    <div class="ticket-row" style="margin-top: 20px;">
        <?php foreach ($reservedTickets as $ticket): ?>
            <div class="ticket-container reserved" id="reserved-ticket-container-<?= htmlspecialchars($ticket->getTicketId()) ?>"
                style="background-color: #f0f0f0; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                <div class="ticket-details">
                    <p class="ticket-info" style="font-size: 19px;">
                        State: <?= htmlspecialchars($ticket->getState()); ?><br>
                        Date: <?= htmlspecialchars($ticket->getTicketDate()); ?><br>
                        Time: <?= htmlspecialchars($ticket->getTicketTime()); ?><br>
                        Quantity: <?= htmlspecialchars($ticket->getQuantity()); ?><br>
                        Price: €<?= htmlspecialchars($ticket->getPrice()); ?> <br>
                        Special Requests: <?= htmlspecialchars($ticket->getSpecialRequest()); ?>
                    </p>
                    <input type="hidden" class="ticket-state" value="<?= htmlspecialchars($ticket->getState()); ?>">
                    <input type="hidden" class="ticket-date" value="<?= htmlspecialchars($ticket->getTicketDate()); ?>">
                    <input type="hidden" class="ticket-time" value="<?= htmlspecialchars($ticket->getTicketTime()); ?>">
                    <input type="hidden" class="ticket-quantity" value="<?= htmlspecialchars($ticket->getQuantity()); ?>">
                    <input type="hidden" class="ticket-special-request" value="<?= htmlspecialchars($ticket->getSpecialRequest()); ?>">
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
                <h2>Total with VAT 21%: €<span id="total-cart-price">0.00</span></h2>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var checkoutButton = document.getElementById('checkout-button');
    checkoutButton.addEventListener('click', collectTicketInfo);
});

function collectTicketInfo() {
    var tickets = document.querySelectorAll('.ticket-container.reserved');
    var ticketsData = [];

    tickets.forEach(function(ticket) {
        var ticketId = ticket.querySelector('input[id^="ticket-id-"]').value; // Assuming the ID follows the pattern you've established
        var ticketPrice = ticket.querySelector('input[id^="ticket-price-"]').value;
        var ticketState = ticket.querySelector('.ticket-state').value;
        var ticketDate = ticket.querySelector('.ticket-date').value;
        var ticketTime = ticket.querySelector('.ticket-time').value;
        var ticketQuantity = ticket.querySelector('.ticket-quantity').value;
        var ticketSpecialRequest = ticket.querySelector('.ticket-special-request').value;

        ticketsData.push({
            id: ticketId,
            price: ticketPrice,
            state: ticketState,
            date: ticketDate,
            time: ticketTime,
            quantity: ticketQuantity,
            specialRequest: ticketSpecialRequest
        });
    });

    console.log(ticketsData);
    // Here, you can now use ticketsData as needed, e.g., send it to a server or use it in calculations.
}


</script>
