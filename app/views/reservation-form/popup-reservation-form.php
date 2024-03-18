<div id="reservationModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ticket Reservation</h5>
                <button ttype="button" class="btn-close close" data-dismiss="modal" aria-label="Close"
                    onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="reservationForm">
                    <div class="form-group">
                        <label>Ticket Information</label>
                        <p id="ticketInfo">Event on <span id="ticketInfoDate"></span> at <span
                                id="ticketInfoTime"></span> end at <span id="ticketInfoEndTime"></span>, Language: <span
                                id="ticketInfoLanguage"></span></p>
                    </div>
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control" id="firstName" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" required>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="tel" class="form-control" id="phoneNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity (Max 4)</label>
                        <input type="number" class="form-control" id="quantity" min="1" max="4" value="1" required
                            onchange="updateTotalPrice()">
                    </div>
                    <div class="form-group">
                        <label>Total Price</label>
                        <p id="totalPrice">0</p>
                    </div>
                    <input type="hidden" id="ticketId">
                    <input type="hidden" id="eventId">
                    <input type="hidden" id="ticketPrice">
                    <input type="hidden" id="ticketDate" name="ticketDate">
                    <input type="hidden" id="ticketTime" name="ticketTime">
                    <input type="hidden" id="ticketEndTime" name="ticketEndTime">
                    <input type="hidden" id="ticketLanguage" name="ticketLanguage">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submitReservationButton">Submit Reservation</button>
            </div>
        </div>
    </div>
</div>

<div id="successPopup" class="modal" tabindex="-1" role="dialog" style="display:none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="padding: 30px">
            <div class="modal-body" id="successPopupContent">
            </div>
        </div>
    </div>
</div>

<?php
$userSession = isset ($_SESSION['user']) ? json_encode([
    'firstName' => $_SESSION['user']['firstName'] ?? 'John',
    'lastName' => $_SESSION['user']['lastName'] ?? 'Doe',
    'address' => $_SESSION['user']['address'] ?? '123 Main St',
    'phoneNumber' => $_SESSION['user']['phoneNumber'] ?? '555-5555',
    'email' => $_SESSION['user']['email'] ?? 'john.doe@example.com'
]) : json_encode([
        'firstName' => 'John',
        'lastName' => 'Doe',
        'address' => '123 Main St',
        'phoneNumber' => '555-5555',
        'email' => 'john.doe@example.com'
    ]);
?>

<style>
.checkmark-circle {
    width: 20px;
    height: 20px;
    position: relative;
    display: inline-block;
    vertical-align: middle;
    margin-bottom: 1rem;
}

.background {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #4bb543;
    position: absolute;
}





</style>
<script>
    var userSession = <?php echo $userSession; ?>;
</script>
<script src="/js/add-reservation.js"></script>