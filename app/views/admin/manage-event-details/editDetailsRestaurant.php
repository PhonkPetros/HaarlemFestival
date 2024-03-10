<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<div class="container mt-5">
    <h2>Restaurant Details</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Picture</th>
                <th>Name</th>
                <th>Price</th>
                <th>Seats</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Edit Resturant Details</th>
                <th>Delete Resturant</th>
            </tr>
        </thead>
        <tbody>
    <?php if (isset($restaurants) && is_array($restaurants)): ?>
        <?php foreach ($restaurants as $restaurant): ?>
            <tr>
                <td><img src="/img/<?= htmlspecialchars($restaurant->getPicture()) ?>" alt="No Image" style="width:100px; height:auto;"></td>
                <td><?= htmlspecialchars($restaurant->getLocation()) ?></td>
                <td><?= htmlspecialchars($restaurant->getPrice()) ?></td>
                <td><?= htmlspecialchars($restaurant->getSeats()) ?></td>
                <td><?= htmlspecialchars($restaurant->getStartDate()) ?></td>
                <td><?= htmlspecialchars($restaurant->getEndDate()) ?></td>
                <td>
                    <button type="button" class="btn btn-primary edit-btn" 
                        data-id="<?= htmlspecialchars($restaurant->getId()) ?>"
                        data-name="<?= htmlspecialchars($restaurant->getLocation()) ?>"
                        data-price="<?= htmlspecialchars($restaurant->getPrice()) ?>"
                        data-seats="<?= htmlspecialchars($restaurant->getSeats()) ?>"
                        data-start-date="<?= htmlspecialchars($restaurant->getStartDate()) ?>"
                        data-end-date="<?= htmlspecialchars($restaurant->getEndDate()) ?>">
                        Edit
                    </button>
                    <button type="button" class="btn btn-primary update-btn" 
                        data-id="<?= htmlspecialchars($restaurant->getId()) ?>"
                        data-name="<?= htmlspecialchars($restaurant->getLocation()) ?>"
                        data-price="<?= htmlspecialchars($restaurant->getPrice()) ?>"
                        data-seats="<?= htmlspecialchars($restaurant->getSeats()) ?>"
                        data-start-date="<?= htmlspecialchars($restaurant->getStartDate()) ?>"
                        data-end-date="<?= htmlspecialchars($restaurant->getEndDate()) ?>">
                        Timeslots
                </td>
                <td>
                    <button type="button" class="btn btn-danger delete-btn" 
                        data-id="<?= htmlspecialchars($restaurant->getId()) ?>">
                        Delete
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>

    <?php else: ?>
        <tr>
            <td colspan="8">No restaurants found.</td>
        </tr>
    <?php endif; ?>
</tbody>

    </table>
</div>

<div id="editModal" class="modal">
    <div class="modal-dialog">
        <form method="post" enctype="multipart/form-data" id="editRestaurantForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Restaurant Details</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editFormId" name="id">
                    <div class="form-group">
                        <label for="editFormName">Name</label>
                        <input type="text" class="form-control" id="editFormName" name="name">
                    </div>
                    <div class="form-group">
                        <label for="editFormPrice">Price</label>
                        <input type="text" class="form-control" id="editFormPrice" name="price">
                    </div>
                    <div class="form-group">
                        <label for="editFormSeats">Seats</label>
                        <input type="number" class="form-control" id="editFormSeats" name="seats">
                    </div>
                    <div class="form-group">
                        <label for="editFormStartDate">Start Date</label>
                        <input type="date" class="form-control" id="editFormStartDate" name="startDate">
                    </div>
                    <div class="form-group">
                        <label for="editFormEndDate">End Date</label>
                        <input type="date" class="form-control" id="editFormEndDate" name="endDate">
                    </div>
                    <div class="form-group">
                        <label for="editFormPicture">Picture</label>
                        <input type="file" class="form-control" id="editFormPicture" name="picture">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChangesBtn" onclick="saveChanges()">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>




<script src="/js/editDetailsResturant.js"></script>


<?php include __DIR__ . '/../../general_views/footer.php'; ?>

