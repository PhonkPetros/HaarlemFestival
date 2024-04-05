document.addEventListener('DOMContentLoaded', function () {
    function openReservationModal(button) {
        var date = button.getAttribute('data-date');
        var time = button.getAttribute('data-time');
        var endTime = button.getAttribute('data-endtime');
        var language = button.getAttribute('data-language');
        var location = button.getAttribute('data-location');
        var restaurantName = button.getAttribute('data-restaurant-name');
        var specialRemarks = button.getAttribute('data-special-remarks');

       
        console.log(`Reservation Data: date=${date}, time=${time}, endTime=${endTime}, language=${language}, location=${location}, restaurantName=${restaurantName}`);

        if (document.getElementById('ticketInfoDate')) document.getElementById('ticketInfoDate').textContent = date || '';
        if (document.getElementById('ticketInfoTime')) document.getElementById('ticketInfoTime').textContent = time || '';
        if (document.getElementById('ticketInfoEndTime')) document.getElementById('ticketInfoEndTime').textContent = endTime || '';
        if (document.getElementById('ticketInfoLanguage')) document.getElementById('ticketInfoLanguage').textContent = language || '';
        if (document.getElementById('ticketInfoRestaurant')) document.getElementById('ticketInfoRestaurant').textContent = restaurantName || '';
        if (document.getElementById('specialRemarks')) document.getElementById('specialRemarks').value = specialRemarks || '';
      
        
        ['ticketId', 'eventId', 'ticketPrice', 'ticketDate', 'ticketTime', 'ticketEndTime', 'ticketLocation', 'ticketRestaurantName', 'specialRequest'].forEach(id => {
            if (document.getElementById(id)) {
                switch (id) {
                    case 'ticketId':
                        document.getElementById(id).value = button.getAttribute('data-ticket-id');
                        break;
                    case 'eventId':
                        document.getElementById(id).value = button.getAttribute('data-event-id');
                        break;
                    case 'ticketPrice':
                        document.getElementById(id).value = button.getAttribute('data-price');
                        break;
                    case 'ticketDate':
                        document.getElementById(id).value = date;
                        break;
                    case 'ticketTime':
                        document.getElementById(id).value = time;
                        break;
                    case 'ticketEndTime':
                        document.getElementById(id).value = endTime;
                        break;
                    case 'ticketLocation':
                        document.getElementById(id).value = location;
                        break;
                    case 'ticketRestaurantName':
                        document.getElementById(id).value = restaurantName || " ";
                        break;
                    case 'specialRemarks':
                        document.getElementById(id).value = specialRemarks || " ";
                        break;
                    
                }
            }
        });

        if (document.getElementById('ticketLanguage')) document.getElementById('ticketLanguage').value = language || " ";
        
        ['firstName', 'lastName', 'address', 'phoneNumber', 'email'].forEach(id => {
            if (document.getElementById(id)) document.getElementById(id).value = userSession[id] || '';
        });

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
            ticketLocation: document.getElementById('ticketLocation').value,
            ticketRestaurantName: document.getElementById('ticketRestaurantName').value,
            specialRemarks: document.getElementById('specialRequest').value || " "
        };    
        if (document.getElementById('firstName')) {
            formData.firstName = document.getElementById('firstName').value;
        }
    
        if (document.getElementById('lastName')) {
            formData.lastName = document.getElementById('lastName').value;
        }
    
        if (document.getElementById('address')) {
            formData.address = document.getElementById('address').value;
        }
    
        if (document.getElementById('phoneNumber')) {
            formData.phoneNumber = document.getElementById('phoneNumber').value;
        }
    
        if (document.getElementById('email')) {
            formData.email = document.getElementById('email').value;
        }
    
        if (document.getElementById('quantity')) {
            formData.quantity = document.getElementById('quantity').value;
        }
    
        if (document.getElementById('ticketId')) {
            formData.ticketId = document.getElementById('ticketId').value;
        }
    
        if (document.getElementById('eventId')) {
            formData.eventId = document.getElementById('eventId').value;
        }
    
        if (document.getElementById('ticketPrice')) {
            formData.ticketPrice = document.getElementById('ticketPrice').value;
        }
    
        if (document.getElementById('ticketDate')) {
            formData.ticketDate = document.getElementById('ticketDate').value;
        }
    
        if (document.getElementById('ticketTime')) {
            formData.ticketTime = document.getElementById('ticketTime').value;
        }
    
        if (document.getElementById('ticketEndTime')) {
            formData.ticketEndTime = document.getElementById('ticketEndTime').value;
        }
    
        if (document.getElementById('ticketLanguage')) {
            formData.ticketLanguage = document.getElementById('ticketLanguage').value || " ";
        }
    
        if (document.getElementById('ticketLocation')) {
            formData.ticketLocation = document.getElementById('ticketLocation').value;
        }
    
        if (document.getElementById('ticketRestaurantName')) {
            formData.ticketRestaurantName = document.getElementById('ticketRestaurantName').value || " ";
        }
    
        if (document.getElementById('specialRemarks')) {
            formData.specialRemarks = document.getElementById('specialRemarks').value || " ";
        }
    
        if (Object.keys(formData).length === 0) {
            console.log("No data to submit.");
            return;
        }
    
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
