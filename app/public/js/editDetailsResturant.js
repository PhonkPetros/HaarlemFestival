document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const restaurantDetails = {
                id: this.dataset.id,
                name: this.dataset.name,
                location: this.dataset.location,
                description: this.dataset.description,
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
    document.querySelector('#editFormLocation').value = details.location;
    document.querySelector('#editFormDescription').value = details.description;
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

function saveChanges(event) {
    event.preventDefault(); // Prevents the default form submission behavior

    const id = document.querySelector('#editFormId').value;
    const name = document.querySelector('#editFormName').value;
    const location = document.querySelector('#editFormLocation').value;
    const description = document.querySelector('#editFormDescription').value;
    const price = document.querySelector('#editFormPrice').value;
    const seats = document.querySelector('#editFormSeats').value;
    const startDate = document.querySelector('#editFormStartDate').value;
    const endDate = document.querySelector('#editFormEndDate').value;

    const formData = new FormData();
    formData.append('id', id);
    formData.append('name', name);
    formData.append('location', location);
    formData.append('description', description);
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
            updateRestaurantRow(id, name, location, description, price, seats, startDate, endDate, data.picturePath);
            closeModal();
        } else {
            console.error('Failed to update:', data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateRestaurantRow(id, name, location, description, price, seats, startDate, endDate, picturePath) {
    const row = document.getElementById(`restaurant-row-${id}`);
    if(row) {
        row.querySelector('.restaurant-name').textContent = name;
        row.querySelector('.restaurant-location').textContent = location;
        row.querySelector('.restaurant-description').textContent = description;
        row.querySelector('.restaurant-price').textContent = price;
        row.querySelector('.restaurant-seats').textContent = seats;
        row.querySelector('.restaurant-start-date').textContent = startDate;
        row.querySelector('.restaurant-end-date').textContent = endDate;
        if (picturePath) {
            row.querySelector('.restaurant-picture img').src = `/img/${picturePath}`; // Assuming the path needs to be prefixed
        }

        const editBtn = row.querySelector('.edit-btn');
        if(editBtn) {
            editBtn.dataset.name = name;
            editBtn.dataset.location = location;
            editBtn.dataset.description = description;
            editBtn.dataset.price = price;
            editBtn.dataset.seats = seats;
            editBtn.dataset.startDate = startDate;
            editBtn.dataset.endDate = endDate;
            if (picturePath) {
                editBtn.dataset.picture = `/img/${picturePath}`;
            }
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
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Timeslot added successfully',
            }).then(() => {
                window.location.reload(); // Refresh the page after successful addition
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to add timeslot: ' + data.message,
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred',
        });
    });
}







document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('#addRestaurantButton').addEventListener('click', function() {
        document.querySelector('#addRestaurantModal').style.display = 'block';
    });

    document.querySelector('#addRestaurantModal .modal-footer button[data-dismiss="modal"]').addEventListener('click', function() {
        closeModalAddRestaurant();
    });
});


function closeModalAddRestaurant() {
    document.querySelector('#addRestaurantModal').style.display = 'none';
}


function addRestaurant(event) {
    event.preventDefault();

    const form = document.getElementById('addRestaurantForm');

    const formData = new FormData(form);

    fetch('/editRestaurantDetails/addRestaurant', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Restaurant added successfully.',
            }).then(() => {
                closeModalAddRestaurant();
                
                const restaurantTableBody = document.querySelector('tbody');
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${formData.get('name')}</td>
                    <td><a href="/manage-event-details/editDetails?id=${data.restaurantId}">Edit</a></td>
                `;
                restaurantTableBody.appendChild(newRow);
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to add the restaurant: ' + data.message,
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while adding the restaurant.',
        });
    });
}






