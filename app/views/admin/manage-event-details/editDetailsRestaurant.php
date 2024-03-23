<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<div class="container mt-5">
    <h2>Restaurant Details</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Picture</th>
                <th>Name</th>
                <th>Location</th>
                <th>Description</th>
                <th>Price</th>
                <th>Seats</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Edit Restaurant Details</th>
                <th>Delete Restaurant</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($restaurants) && is_array($restaurants)): ?>
                <?php foreach ($restaurants as $restaurant): ?>
                    <tr id="restaurant-row-<?= htmlspecialchars($restaurant->getId()) ?>">
                        <td class="restaurant-id"><?= htmlspecialchars($restaurant->getId()) ?></td>
                        <td class="restaurant-picture"><img src="/img/<?= htmlspecialchars($restaurant->getPicture()) ?>" alt="No Image" style="width:100px; height:auto;"></td>
                        <td class="restaurant-name"><?= htmlspecialchars($restaurant->getName()) ?></td>
                        <td class="restaurant-location"><?= htmlspecialchars($restaurant->getLocation()) ?></td>
                        <td class="restaurant-description"><?= htmlspecialchars($restaurant->getDescription()) ?></td>
                        <td class="restaurant-price"><?= htmlspecialchars($restaurant->getPrice()) ?></td>
                        <td class="restaurant-seats"><?= htmlspecialchars($restaurant->getSeats()) ?></td>
                        <td class="restaurant-start-date"><?= htmlspecialchars($restaurant->getStartDate()) ?></td>
                        <td class="restaurant-end-date"><?= htmlspecialchars($restaurant->getEndDate()) ?></td>
                        <td>
                            <button type="button" class="btn btn-primary edit-btn"
                                    data-id="<?= htmlspecialchars($restaurant->getId()) ?>"
                                    data-name="<?= htmlspecialchars($restaurant->getName()) ?>"
                                    data-location="<?= htmlspecialchars($restaurant->getLocation()) ?>"
                                    data-description="<?= htmlspecialchars($restaurant->getDescription()) ?>"
                                    data-price="<?= htmlspecialchars($restaurant->getPrice()) ?>"
                                    data-seats="<?= htmlspecialchars($restaurant->getSeats()) ?>"
                                    data-start-date="<?= htmlspecialchars($restaurant->getStartDate()) ?>"
                                    data-end-date="<?= htmlspecialchars($restaurant->getEndDate()) ?>">
                                Edit
                            </button>
                            <button type="button" class="btn btn-primary add-timeslot-btn" data-id="<?= htmlspecialchars($restaurant->getId()) ?>">Add Timeslot</button>
                        </td>
                        <td>
                        <form method="POST" action="/restaurant/delete">
                            <input type="hidden" name="delete_restaurant_id" value="<?= htmlspecialchars($restaurant->getId()) ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                        </td>
                        
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No restaurants found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="container mt-5">
    <h2>Restaurant Timeslots</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Quantity</th>
                <th>Date</th>
                <th>Time</th>
                <th>Delete Timeslot</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($tickets) && is_array($tickets)): ?>
                <?php foreach ($tickets as $ticket): ?>
                    <tr>
                        <td><?= htmlspecialchars($ticket->getQuantity()) ?></td>
                        <td><?= htmlspecialchars($ticket->getTicketDate()) ?></td>
                        <td><?= htmlspecialchars($ticket->getTicketTime()) ?></td>
                        <td>
                        <form method="post" action="/restaurant/deletetimeslot">
                            <input type="hidden" name="delete_timeslot_id" value="<?= htmlspecialchars($ticket->getTicketHash()) ?>">
                            <button type="submit" class="btn btn-danger delete-timeslot-btn">Delete</button> 
                        </form>
                    </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($tickets)): ?>
                    <tr>
                        <td colspan="3">No timeslots found.</td>
                    </tr>
                <?php endif; ?>
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
                        <label for="editFormLocation">Location</label>
                        <input type="text" class="form-control" id="editFormLocation" name="location">
                    </div>
                    <div class="form-group">
                        <label for="editFormDescription">Description</label>
                        <textarea class="form-control" id="editFormDescription" name="description" rows="3"></textarea>
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
                        <input type="file" class="form-control-file" id="editFormPicture" name="picture">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Close</button> <!-- Added data-dismiss attribute -->
                    <button type="submit" class="btn btn-primary"  onclick="saveChanges(event)">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div id="addTimeslotModal" class="modal">
    <div class="modal-dialog">
        <form method="post" id="addTimeslotForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Timeslot</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="addTimeslotFormId" name="restaurantId">
                    <div class="form-group">
                        <label for="timeslotDate">Date</label>
                        <input type="date" class="form-control" id="timeslotDate" name="date">
                    </div>
                    <div class="form-group">
                        <label for="timeslotTime">Time</label>
                        <input type="time" class="form-control" id="timeslotTime" name="time">
                    </div>
                    <div class="form-group">
                        <label for="timeslotQuantity">Quantity</label>
                        <input type="number" class="form-control" id="timeslotQuantity" name="quantity">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModalTimeSlot()">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="addTimeSlot()">Add Timeslot</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="/js/editDetailsResturant.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php include __DIR__ . '/../../general_views/footer.php'; ?>

