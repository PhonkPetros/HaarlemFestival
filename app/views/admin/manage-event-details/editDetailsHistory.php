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
                        <img src="/../img/<?= htmlspecialchars($eventDetails->getPicture()) ?>" alt="Event Image"
                            class="img-fluid" style="max-width: 100%; height: auto;">
                    </div>
                    <?Php /* Below use a popup modal similar to how I do it in the manage users page. */ ?>
                    <a href="edit-event.php?id=<?= htmlspecialchars($eventDetails->getEventId()) ?>"
                        class="btn btn-primary">Edit Event Details</a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-center">
                    <u>Time Slots</u>
                </div>
                <div class="card-body">
                    <?php if (empty($eventTickets)): ?>
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
                                <p><strong>Time:</strong>
                                    <?= htmlspecialchars($ticket->getTicketTime()) ?>
                                </p>
                                <p><strong>Quantity:</strong>
                                    <?= htmlspecialchars($ticket->getQuantity()) ?>
                                </p>

                                <a href="edit-ticket.php?id=<?= htmlspecialchars($ticket->getTicketId()) ?>"
                                    class="btn btn-primary">Edit Timeslot</a>
                                    <a href="delet-ticket.php?id=<?= htmlspecialchars($ticket->getTicketId()) ?>"
                                    class="btn btn-danger">Delete Timeslot</a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <button type="button" id="openModal" class="btn btn-primary"
                        data-event-id="<?= htmlspecialchars($eventDetails->getEventId()) ?>">
                        Add New Timeslot
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="ticketModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Timeslot</h5>
                <button type="button" id="closeModal" class="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="addTicketForm">
                    <div class="mb-3">
                        <label for="newDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="newDate" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="newQuantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="newQuantity" name="quantity" required>
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
                        <label for="addnewtime" class="form-label">Time</label>
                        <input type="time" class="form-control" id="addnewtime" name="time" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="addTicketForm" class="btn btn-primary">Add New Timeslot</button>
            </div>
        </div>
    </div>
</div>

<script src="/js/editDetailsHistory.js"></script>
<?php include __DIR__ . '/../../general_views/footer.php'; ?>