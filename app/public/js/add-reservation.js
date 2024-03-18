document.addEventListener('DOMContentLoaded', function () {
    function openReservationModal(button) {
        var date = button.getAttribute('data-date');
        var time = button.getAttribute('data-time');
        var endTime = button.getAttribute('data-endtime');
        var language = button.getAttribute('data-language');
        
        document.getElementById('ticketInfoDate').textContent = date;
        document.getElementById('ticketInfoTime').textContent = time;
        document.getElementById('ticketInfoEndTime').textContent = endTime;
        document.getElementById('ticketInfoLanguage').textContent = language;
        
        document.getElementById('ticketId').value = button.getAttribute('data-ticket-id');
        document.getElementById('eventId').value = button.getAttribute('data-event-id');
        document.getElementById('ticketPrice').value = button.getAttribute('data-price');
        
        document.getElementById('ticketDate').value = date;
        document.getElementById('ticketTime').value = time;
        document.getElementById('ticketEndTime').value = endTime;
        document.getElementById('ticketLanguage').value = language;
    
        document.getElementById('firstName').value = userSession.firstName || '';
        document.getElementById('lastName').value = userSession.lastName || '';
        document.getElementById('address').value = userSession.address || '';
        document.getElementById('phoneNumber').value = userSession.phoneNumber || '';
        document.getElementById('email').value = userSession.email || '';
    
        document.getElementById('submitReservationButton').addEventListener('click', submitReservation);
        
        updateTotalPrice();
        document.getElementById('reservationModal').style.display = 'block';
    }
    

    function closeModal() {
        document.getElementById('reservationModal').style.display = 'none';
    }
    window.closeModal = closeModal;

    function updateTotalPrice() {
        var quantityInput = document.getElementById('quantity');
        var quantity = parseInt(quantityInput.value, 10);
        var maxQuantity = parseInt(quantityInput.max, 10);
        if (quantity > maxQuantity) {
            quantity = maxQuantity;
            quantityInput.value = maxQuantity;
        }

        var price = document.getElementById('ticketPrice').value;
        var totalPrice = quantity * price;
        document.getElementById('totalPrice').innerText = `${totalPrice.toFixed(2)} €`;
    }

    document.getElementById('quantity').addEventListener('input', updateTotalPrice);

    document.querySelectorAll('.btn-reserve').forEach(button => {
        button.addEventListener('click', function () {
            openReservationModal(this);
        });
    });

    function submitReservation() {
        var formData = {
            firstName: document.getElementById('firstName').value,
            lastName: document.getElementById('lastName').value,
            address: document.getElementById('address').value,
            phoneNumber: document.getElementById('phoneNumber').value,
            email: document.getElementById('email').value,
            quantity: document.getElementById('quantity').value,
            ticketId: document.getElementById('ticketId').value,
            eventId: document.getElementById('eventId').value,
            ticketPrice: document.getElementById('ticketPrice').value,
            ticketDate: document.getElementById('ticketDate').value,
            ticketTime: document.getElementById('ticketTime').value,
            ticketEndTime: document.getElementById('ticketEndTime').value,
            ticketLanguage: document.getElementById('ticketLanguage').value,
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

    function showSuccessPopup(message) {
        var popupContent = `
            <p>${message}</p>
            <button type="button" class="btn btn-secondary" id="continueShopping">Continue Shopping</button>
            <button type="button" class="btn btn-primary" id="goToMyProgram">Go to My Program</button>
        `;

        document.getElementById('successPopupContent').innerHTML = popupContent;
        document.getElementById('successPopup').style.display = 'block';
 
        document.getElementById('continueShopping').addEventListener('click', closeSuccessPopup);
        document.getElementById('goToMyProgram').addEventListener('click', goToMyProgram);
    }

    function goToMyProgram() {
        window.location.href = '/my-program';
    }
    
    function closeSuccessPopup() {
        document.getElementById('successPopup').style.display = 'none';
    }

    document.getElementById('reservationForm').addEventListener('submit', function (event) {
        event.preventDefault();
        submitReservation();
    });
});
