<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>



<div class="container mt-5" style="margin-top: 10px">
<h1 class="mb-4 text-center">Edit History Event Details</h1>
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-center">
                    <u>Current Event Details</u>
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <?= htmlspecialchars($eventDetails->getName()) ?>
                    </h5>
                    <p class="card-text"><strong>Start Date:</strong>
                        <?= htmlspecialchars($eventDetails->getStartDate()) ?>
                    </p>
                    <p class="card-text"><strong>End Date:</strong>
                        <?= htmlspecialchars($eventDetails->getEndDate()) ?>
                    </p>
                    <p class="card-text"><strong>Location:</strong>
                        <?= htmlspecialchars($eventDetails->getLocation()) ?>
                    </p>
                    <p class="card-text"><strong>Price:</strong>
                        <?= htmlspecialchars($eventDetails->getPrice()) ?>
                    </p>
                    <div class="mb-3 text-center">
                        <p class="card-text"><strong>Picture:</strong></p>
                        <img src="<?= htmlspecialchars($eventDetails->getPicture()) ?>" alt="Event Image"
                            class="img-fluid" style="max-width: 100%; height: 450px;">
                    </div>
                    <button type="button" id="editEventDetailsButton" class="btn btn-primary"
                        data-event-id="<?= htmlspecialchars($eventDetails->getEventId()) ?>">Edit Event Details</button>
                    <button type="button" id="addTimeslotButton" class="btn btn-primary"
                        data-event-id="<?= htmlspecialchars($eventDetails->getEventId()) ?>">Add New Timeslot</button>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-center">
                    <u>Time Slots</u>
                </div>
                <div class="overflow-auto" style="max-height: 770px;">
                    <div class="card-body ">
                        <?php if (empty ($eventTickets)): ?>
                            <p>No tickets available.</p>
                        <?php else: ?>
                            <?php foreach ($eventTickets as $ticket): ?>
                                <div class="ticket-row mb-3">
                                    <p><strong>Language:</strong>
                                        <?= htmlspecialchars($ticket->getTicketLanguage()) ?>
                                    </p>
                                    <p><strong>Date:</strong>
                                        <?= htmlspecialchars($ticket->getTicketDate()) ?>
                                    </p>
                                    <p><strong>Start Time:</strong>
                                        <?= htmlspecialchars($ticket->getTicketTime()) ?>
                                    </p>
                                    <p><strong>End Time:</strong>
                                        <?php
                                        echo $ticket->getTicketEndTime() ? htmlspecialchars(date('H:i', strtotime($ticket->getTicketEndTime()))) : '';
                                        ?>
                                    </p>

                                    <p><strong>Quantity:</strong>
                                        <?= htmlspecialchars($ticket->getQuantity()) ?>
                                    </p>
                                    <button type="button" class="btn btn-danger deleteTimeslotButton"
                                        data-ticket-id="<?= htmlspecialchars($ticket->getTicketId()) ?>">Delete
                                        Timeslot</button>

                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-danger" style="margin-bottom: 20px" onclick="window.history.back();">Go
        Back</button>
</div>

<? include __DIR__ . '/../components/addtimeslothistorypopup.php' ?>
<? include __DIR__ . '/../components/editeventdetailshistorypopup.php' ?>
<? include __DIR__ . '/../../general_views/popupmessage.php'?>
<script src="/js/editDetailsHistory.js"></script>
<?php include __DIR__ . '/../../general_views/footer.php'; ?>