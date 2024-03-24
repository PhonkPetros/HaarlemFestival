<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<script>
    const danceEvents = [];
    <?php foreach ($danceEvents as $event): ?>
        <?php $eventJson = $event->jsonSerialize() ?>
        danceEvents.push(<?= json_encode($eventJson) ?>);
    <?php endforeach; ?>
</script>

<h1>Edit Dance Event Details</h1>
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-center">
                    <u>Event Details</u>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary editEventDetailsButton"
                        data-event-id="">Create New Event</button>
                    <?php foreach ($danceEvents as $event): ?>
                        <div class="dance-event">
                            <img src="<?= htmlspecialchars($event->getImage()) ?>" alt="" width="100px" height="100px">
                            <div class="dance-event-information">
                                <h5 class="card-title">
                                    <?= htmlspecialchars($event->getVenue()) ?>
                                    <span>-</span>
                                    <?= htmlspecialchars($event->getFormattedDateTime()) ?>
                                </h5>
                                <p class="card-text"><strong>Address:</strong>
                                    <?= htmlspecialchars($event->getAddress()) ?>
                                </p>
                                <p class="card-text"><strong>Price:</strong>
                                    €<?= htmlspecialchars($event->getPrice()) ?>
                                </p>
                                <p class="card-text"><strong>Artists:</strong>
                                    <?php foreach ($event->getArtists() as $artist): ?>
                                        <div class="participating-artist">
                                            <button type="button" class="btn btn-danger">Remove</button>
                                            <?= htmlspecialchars($artist->getName()) ?>
                                        </div>
                                    <?php endforeach; ?>
                                </p>
                                <button type="button" class="btn btn-primary editEventDetailsButton"
                                    data-event-id="<?= htmlspecialchars($event->getDanceEventId()) ?>">Edit Event Details</button>
                                <button type="button" class="btn btn-primary addNewArtistButton"
                                    data-event-id="<?= htmlspecialchars($event->getDanceEventId()) ?>">Add New Artist</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-center">
                    <u>Artists</u>
                </div>
                <div class="overflow-auto" style="max-height: 770px;">
                    <div class="card-body ">
                        <?php if (empty ($eventTickets)): ?>
                            <p>No Artists Available</p>
                        <?php else: ?>
                            
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-danger" style="margin-bottom: 20px" onclick="window.history.back();">Go Back</button>
</div>

<div id="eventDetailsModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="venue" class="form-label">Venue</label>
                    <input type="text" class="form-control" id="venue" name="venue">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address">
                </div>
                <div class="mb-3">
                    <label for="dateTime" class="form-label">Date and Time</label>
                    <input type="datetime-local" class="form-control" id="dateTime" name="dateTime">
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-event-save">Save</button>
            </div>
        </div>
    </div>
</div>

<script src="/js/editDetailsDance.js"></script>
<?php include __DIR__ . '/../../general_views/footer.php'; ?>