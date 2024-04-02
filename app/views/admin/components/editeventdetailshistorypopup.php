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