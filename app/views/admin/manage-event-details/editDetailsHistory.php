<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<h1 class="mb-4 text-center">Edit History Event Details</h1>

<div class="container mt-5">
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

<div id="addTimeslotModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Timeslot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTimeslotForm">
                    <div class="mb-3">
                        <label for="newDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="newDate" name="date" required
                            min="<?php echo $eventDetails->getStartDate() ?>"
                            max="<?php echo $eventDetails->getEndDate() ?>">
                    </div>
                    <div class="mb-3">
                        <label for="newQuantity" class="form-label">Quantity</label>
                        <input type="number" min="1" max="12" class="form-control" id="newQuantity" name="quantity"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="newLanguage" class="form-label">Language</label>
                        <select class="form-select" id="newLanguage" name="language" required>
                            <option value="">Select Language</option>
                            <option value="english">English</option>
                            <option value="chinese">Chinese</option>
                            <option value="dutch">Dutch</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="addnewtime" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="addnewtime" name="time" required>
                    </div>
                    <div class="mb-3">
                        <label for="addnewendtime" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="addnewendtime" name="endtime" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="addTimeslotForm" class="btn btn-primary">Add New Timeslot</button>
            </div>
        </div>
    </div>
</div>

<div id="editEventDetailsModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEventForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="newEventName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="newEventName" name="name"
                            value="<?= htmlspecialchars($eventDetails->getName()) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="newStartDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="newStartDate" name="startDate"
                            value="<?= htmlspecialchars($eventDetails->getStartDate()) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="newEndDate" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="newEndDate" name="endDate"
                            value="<?= htmlspecialchars($eventDetails->getEndDate()) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="newLocation" class="form-label">Location</label>
                        <input type="text" class="form-control" id="newLocation" name="location"
                            value="<?= htmlspecialchars($eventDetails->getLocation()) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="newPrice" class="form-label">Price</label>
                        <input type="number" step="any" min="0" class="form-control" id="newPrice" name="price"
                            value="<?= htmlspecialchars($eventDetails->getPrice()) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="newImage" class="form-label">Change Image</label>
                        <input type="file" class="form-control" id="newImage" name="image" accept=".jpg, .jpeg, .png">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="editEventForm" class="btn btn-primary">Submit New Details</button>
            </div>
        </div>
    </div>

</div>



<script src="/js/editDetailsHistory.js"></script>
<?php include __DIR__ . '/../../general_views/footer.php'; ?>