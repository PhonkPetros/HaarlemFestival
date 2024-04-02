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