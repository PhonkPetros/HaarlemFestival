$(document).on('click', '.btn-choose-ticket', function () {
    const danceEventId = $(this).data('event-id');
    document.getElementById('ticketId').value = danceEventId;

    const event = artistDetails.find(detail => detail.event_id === danceEventId.toString());
    console.log(event);
    $("#ticketId").val(danceEventId);
    $("#eventId").val(event.event_id);
    $("#quantity").val(1);
    $("#ticketPrice").val(event.price);
    const dateTime = new Date(event.dateTime);
    const endDateTime = new Date(event.endDateTime);
    const date = dateTime.toISOString().split('T')[0];
    const time = dateTime.toTimeString().split(' ')[0];
    const endTime = endDateTime.toTimeString().split(' ')[0];
    $("#ticketDate").val(date);
    $("#ticketTime").val(time);
    $("#ticketEndTime").val(endTime);
    $("#totalPrice").html(`€${event.price}`);
    document.getElementById('reservationModal').style.display = 'block';
});

function closeModal() {
    document.getElementById('reservationModal').style.display = 'none';
}

function updateTotalPrice() {
    const quantity = document.getElementById('quantity').value;
    const event = artistDetails.find(detail => detail.event_id === document.getElementById('ticketId').value);
    const ticketType = $('#ticket-type').val();

    let totalPrice = 0;

    if (ticketType === 'regular') {
        $('#totalPrice').html(`€${event.price * quantity}`);
        totalPrice = event.price * quantity;
    } else if (ticketType === 'onedayaccess') {
        $('#totalPrice').html(`€${event.oneDayPrice * quantity}`);
        totalPrice = event.oneDayPrice * quantity;
    } else if (ticketType === 'alldaysaccess') {
        $('#totalPrice').html(`€${event.allDaysPrice * quantity}`);
        totalPrice = event.allDaysPrice * quantity;
    }

    $("#ticketPrice").val(totalPrice);
}

$('#submitReservationButton').on('click', function () {
    submitReservation();
});

function submitReservation() {
    var formData = {
        quantity: document.getElementById('quantity').value,
        eventId: document.getElementById('eventId').value,
        ticketId: document.getElementById('ticketId').value,
        ticketType: document.getElementById('ticket-type').value,
        ticketPrice: document.getElementById('ticketPrice').value,
        ticketDate: document.getElementById('ticketDate').value,
        ticketTime: document.getElementById('ticketTime').value,
        ticketEndTime: document.getElementById('ticketEndTime').value,
    };

    fetch('/submit-reservation', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
    })
    .then(response => response.json().then(data => ({ status: response.status, body: data })))
    .then(obj => {
        if (obj.status === 200 && obj.body.status === 'success') {
            console.log('Success:', obj.body.message);
            showSuccessPopup(obj.body.message);
            closeModal();
        } else {
            console.error('Server-side error:', obj.body.message);
            alert(obj.body.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('An error occurred while submitting the reservation.');
    });
}

function goToMyProgram() {
    window.location.href = '/my-program';
}

function closeSuccessPopup() {
    document.getElementById('successPopup').style.display = 'none';
}

function showSuccessPopup(message) {
    var popupContent = `
    <div class="text-center">
    <img style=" width: 70px;
    height: 70px;" src="/../img/checkbox-circle-fill.png" alt="Success" class="checkmark-circle-img" />
    <h4>You have successfully reserve this event. You can find your reservation in “My Program” page</h4>
    <button type="button" class="btn btn-dark" id="continueShopping">Continue Shopping</button>
    <button type="button" class="btn btn-dark" id="goToMyProgram">Go to My Program</button>
</div>
    `;

    document.getElementById('successPopupContent').innerHTML = popupContent;
    document.getElementById('successPopup').style.display = 'block';

    document.getElementById('continueShopping').addEventListener('click', closeSuccessPopup);
    document.getElementById('goToMyProgram').addEventListener('click', goToMyProgram);
}