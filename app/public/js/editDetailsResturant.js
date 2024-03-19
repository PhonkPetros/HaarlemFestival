document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const restaurantDetails = {
                id: this.dataset.id,
                name: this.dataset.name,
                price: this.dataset.price,
                seats: this.dataset.seats,
                startDate: this.dataset.startDate,
                endDate: this.dataset.endDate
            };
            
            populateEditForm(restaurantDetails);
        });
    });
});

function populateEditForm(details) {
    document.querySelector('#editModal').style.display = 'block';
    document.querySelector('#editFormId').value = details.id;
    document.querySelector('#editFormName').value = details.name;
    document.querySelector('#editFormPrice').value = details.price;
    document.querySelector('#editFormSeats').value = details.seats;
    document.querySelector('#editFormStartDate').value = details.startDate;
    document.querySelector('#editFormEndDate').value = details.endDate;
}

function closeModal() {
    document.querySelector('#editModal').style.display = 'none';
}

function closeModalTimeSlot() {
    document.querySelector('#addTimeslotModal').style.display = 'none';
}

function saveChanges() {
    const id = document.querySelector('#editFormId').value;
    const name = document.querySelector('#editFormName').value;
    const price = document.querySelector('#editFormPrice').value;
    const seats = document.querySelector('#editFormSeats').value;
    const startDate = document.querySelector('#editFormStartDate').value;
    const endDate = document.querySelector('#editFormEndDate').value;
    
    const formData = new FormData();
    formData.append('id', id);
    formData.append('name', name);
    formData.append('price', price);
    formData.append('seats', seats);
    formData.append('startDate', startDate);
    formData.append('endDate', endDate);
    
    const pictureInput = document.querySelector('#editFormPicture');
    if (pictureInput.files.length > 0) {
        formData.append('picture', pictureInput.files[0]);
    }
    
    fetch('/editResturantDetails/updateRestaurantDetails', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            updateRestaurantRow(id, name, price, seats, startDate, endDate, data.picturePath);
            closeModal();
        } else {
            console.error('Failed to update:', data.message);
        }
    })
    .catch(error => console.error('Error:', error));
    
}

function updateRestaurantRow(id, name, price, seats, startDate, endDate, picturePath) {
    const row = document.getElementById(`restaurant-row-${id}`);
    if(row) {
        if (picturePath) {
            row.querySelector('.restaurant-picture img').src = picturePath;
        }
        row.querySelector('.restaurant-name').textContent = name;
        row.querySelector('.restaurant-price').textContent = price;
        row.querySelector('.restaurant-seats').textContent = seats;
        row.querySelector('.restaurant-start-date').textContent = startDate;
        row.querySelector('.restaurant-end-date').textContent = endDate;
    }

    const editBtn = row.querySelector('.edit-btn');
    if(editBtn) {
        editBtn.dataset.name = name;
        editBtn.dataset.price = price;
        editBtn.dataset.seats = seats;
        editBtn.dataset.startDate = startDate;
        editBtn.dataset.endDate = endDate;
        if (picturePath) {
            editBtn.dataset.picture = picturePath;
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const addTimeslotButtons = document.querySelectorAll('.add-timeslot-btn');
    addTimeslotButtons.forEach(button => {
        button.addEventListener('click', function() {
            document.querySelector('#addTimeslotModal').style.display = 'block';

            const restaurantId = this.getAttribute('data-id');
            const row = document.getElementById(`restaurant-row-${restaurantId}`);
            if (row) {
                const startDate = row.querySelector('.restaurant-start-date').textContent;
                const endDate = row.querySelector('.restaurant-end-date').textContent;

                let dateInput = document.querySelector('#timeslotDate');
                if (dateInput) {
                    dateInput.setAttribute('min', startDate);
                    dateInput.setAttribute('max', endDate);
                }
            }

            document.querySelector('#addTimeslotFormId').value = restaurantId;
        });
    });
});

function addTimeSlot() {
    // Prevent the default form submission
    event.preventDefault();

    const restaurantId = document.querySelector('#addTimeslotFormId').value;
    const date = document.querySelector('#timeslotDate').value;
    const time = document.querySelector('#timeslotTime').value;
    const quantity = document.querySelector('#timeslotQuantity').value;

    const formData = new FormData();
    formData.append('restaurantId', restaurantId);
    formData.append('date', date);
    formData.append('time', time);
    formData.append('quantity', quantity);

    fetch('/editResturantDetails/addTimeSlot', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Timeslot added successfully');
            closeModalTimeslot();
        } else {
            alert('Failed to add timeslot: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}



document.addEventListener('DOMContentLoaded', function() {
    // Add event listener to the "Add Restaurant" button
    document.querySelector('#addRestaurantButton').addEventListener('click', function() {
        // Display the "Add Restaurant" modal
        document.querySelector('#addRestaurantModal').style.display = 'block';
    });

    // Add event listener to close the modal when the "Close" button is clicked
    document.querySelector('#addRestaurantModal .modal-footer button[data-dismiss="modal"]').addEventListener('click', function() {
        closeModalAddRestaurant();
    });
});


function closeModalAddRestaurant() {
    document.querySelector('#addRestaurantModal').style.display = 'none';
}


function addRestaurant(event){
    event.preventDefault();

    const form = document.getElementById('addRestaurantForm');

    const formData = new FormData(form);

    fetch('/editResturantDetails/addRestaurant', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            alert('Restaurant added successfully.');
            closeModalAddRestaurant();
        } else {
            alert('Failed to add the restaurant: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding the restaurant.');
    });
}
