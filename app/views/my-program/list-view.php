<div class="container mt-4 item-container">
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col-auto">
            <h3 style="text-decoration: underline;">My Cart</h3>
        </div>
        <div class="col-auto">
            <!-- <button class="btn btn-primary" onclick="generateAndShareLink()">Share Cart</button>
            <a id="shareLink" style="display: none;" onclick="copyToClipboard(event)">Copy Link</a> -->
        </div>
    </div>

    <div class="ticket-row" >
        <?php foreach ($structuredTickets as $eventId => $eventData): ?>
            <?php foreach ($eventData['tickets'] as $ticket): ?>
                <div class="ticket-container" id="ticket-container-<?= $ticket['ticketId'] ?>"
                    style="background-image: url('<?php echo $eventData['image']; ?>');">

                    <div class="ticket-details">
                        <h5 class="ticket-title">
                            <?php echo htmlspecialchars($eventData['event_name']); ?>
                        </h5>
                        <p class="ticket-info" style="font-size: 19px;">
                            Location:
                            <?php echo htmlspecialchars($ticket['ticketLocation']); ?><br>
                            Date:
                            <?php echo htmlspecialchars($ticket['ticketDate']); ?><br>
                            Start Time:
                            <?php echo htmlspecialchars($ticket['ticketTime']); ?><br>
                            End Time:
                            <?php echo htmlspecialchars($ticket['ticketEndTime']); ?><br>
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
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <?php if (empty ($structuredTickets)): ?>
        <div style="justify-content: center; text-align: center; color: black;">
            <h2>No Tickets Currently In Basket</h2>
        </div>
    <?php else: ?>
        <div class="row justify-content-end" style="border-top: 1px solid black; padding-top: 10px; margin-top: 20px">
            <div class="col-auto"></div>
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

