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
            row.querySelector('.restaurant-picture img').src = picturePath; // Update with new image path
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
            editBtn.dataset.picture = picturePath; // Assuming you have a data attribute for picture
        }
    }
}









