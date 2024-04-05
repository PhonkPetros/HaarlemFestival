<div id="reservationModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ticket Reservation</h5>
                <button ttype="button" class="btn-close close" data-dismiss="modal" aria-label="Close"
                    onclick="closeModal()">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="reservationForm">
                    <div class="form-group mb-3">
                        <label for="quantity">Ticket Type</label>
                        <select class="form-select" name="ticket-type" id="ticket-type" onchange="updateTotalPrice()">
                            <option value="regular">Regular Ticket</option>
                            <option value="onedayaccess">One Day Access</option>
                            <option value="alldaysaccess">All Days Access</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" min="1" value="1" required
                            onchange="updateTotalPrice()">
                    </div>
                    <div class="form-group">
                        <label>Total Price: </label>
                        <div id="totalPrice">0</div>
                    </div>
                    <input type="hidden" id="ticketId">
                    <input type="hidden" id="eventId" value="3">
                    <input type="hidden" id="ticketPrice">
                    <input type="hidden" id="ticketDate" name="ticketDate">
                    <input type="hidden" id="ticketTime" name="ticketTime">
                    <input type="hidden" id="ticketEndTime" name="ticketEndTime">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submitReservationButton">Submit Reservation</button>
            </div>
        </div>
    </div>
</div>

<div id="successPopup" class="modal" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div id="successPopupContent">
                    <div class="checkmark-circle">
                        <div class="background"></div>
                        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                            <path class="checkmark-check" stroke="#fff" stroke-width="2" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                        </svg>
                    </div>
                    <h3>Success!</h3>
                    <p>Your reservation has been confirmed.</p>
                </div>
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
<script src="/js/dance-reservation.js"></script>