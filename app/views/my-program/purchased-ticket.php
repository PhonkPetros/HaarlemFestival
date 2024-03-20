<div class="container mt-4 item-container">
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col-auto">
            <h3 style="text-decoration: underline;">Purchased Items</h3>
        </div>
    </div>

    <?php if (empty ($structuredOrderedItems)): ?>
        <div class="text-center text-black">
            <h2>No Tickets Have Been Purchased.</h2>
        </div>
    <?php else: ?>
        <div class="d-flex flex-nowrap overflow-auto">
            <?php foreach ($structuredOrderedItems as $item): ?>
                <?php
                $startTime = new DateTime($item['start_time']);
                $endTime = new DateTime($item['end_time']);
                ?>
                <div class="ticket-container flex-shrink-0"
                    style="background-image: url('<?php echo htmlspecialchars($item['event_details']['image']); ?>'); width: 300px; height: 300px; background-size: cover; margin-right: 15px;">
                    <div class="ticket-details p-3"
                        style="background: rgba(0, 0, 0, 0.5);  bottom: 0; width: 100%; height: 360px;">
                        <div style="position: center;"> 
                            <h5 class="ticket-title text-white" style="padding: 30px; margin: 6px">
                                <?php echo htmlspecialchars($item['event_details']['event_name']); ?>
                            </h5>
                            <p class="ticket-info text-white" style="">
                                Location:
                                <?php echo htmlspecialchars($item['location']); ?><br>
                                Date:
                                <?php echo htmlspecialchars($item['date']); ?><br>
                                Start Time:
                                <?php echo $startTime->format('H:i'); ?><br>
                                End Time:
                                <?php echo $endTime->format('H:i'); ?><br>
                                Quantity:
                                <?php echo htmlspecialchars($item['quantity']); ?><br>
                                <?php if (!empty ($item['language'])): ?>
                                    Language:
                                    <?php echo htmlspecialchars($item['language']); ?><br>
                                <?php endif; ?>
                                <?php if (!empty ($item['restaurant_name'])): ?>
                                    Restaurant:
                                    <?php echo htmlspecialchars($item['restaurant_name']); ?><br>
                                <?php endif; ?>
                                <?php if (!empty ($item['ticket_type'])): ?>
                                    Ticket Type:
                                    <?php echo htmlspecialchars($item['ticket_type']); ?><br>
                                    Artist:
                                    <?php echo htmlspecialchars($item['artist_name']); ?>
                                <?php endif; ?>
                            </p>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>