<?php include __DIR__ . '/../general_views/adminheader.php'; ?>

<div class="content">
    <h1>Manage Festival Events</h1>
    <p style="font-size: 20px">Click on the event you want to manage to modify or add event details, prices, available slots, etc.</p>
    <p style="font-size: 20px; padding-bottom: 20px;">To edit the content of a page, please go to the page management page</p>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Events</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allEvents as $event): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['name']); ?></td>
                        <td>
                            <a href="/manage-event-details/editDetails?id=<?php echo htmlspecialchars($event['event_id']); ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div id="addRestaurantButtonContainer" class="container mt-3">
            <button type="button" class="btn btn-success" id="addRestaurantButton">Add Restaurant</button>
        </div>
        <div id="addRestaurantModal" class="modal">
        <div class="modal-dialog">
            <form method="post" id="addRestaurantForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Restaurant</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="addFormName">Name</label>
                            <input type="text" class="form-control" id="addFormName" name="name">
                        </div>
                        <div class="form-group">
                            <label for="addFormLocation">Location</label>
                            <input type="text" class="form-control" id="addFormLocation" name="location">
                        </div>
                        <div class="form-group">
                            <label for="addFormDescription">Description</label>
                            <textarea class="form-control" id="addFormDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="addFormPrice">Price</label>
                            <input type="text" class="form-control" id="addFormPrice" name="price">
                        </div>
                        <div class="form-group">
                            <label for="addFormSeats">Seats</label>
                            <input type="number" class="form-control" id="addFormSeats" name="seats">
                        </div>
                        <div class="form-group">
                            <label for="addFormStartDate">Start Date</label>
                            <input type="date" class="form-control" id="addFormStartDate" name="startDate">
                        </div>
                        <div class="form-group">
                            <label for="addFormEndDate">End Date</label>
                            <input type="date" class="form-control" id="addFormEndDate" name="endDate">
                        </div>
                        <div class="form-group">
                            <label for="addFormPicture">Picture</label>
                            <input type="file" class="form-control" id="addFormPicture" name="picture">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModalAddRestaurant()">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="addRestaurant(event)">Add Restaurant</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
<script src="/js/editDetailsResturant.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php include __DIR__ . '/../general_views/footer.php'; ?>
