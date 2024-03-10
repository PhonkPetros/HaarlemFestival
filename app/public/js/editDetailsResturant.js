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
    const formData = new FormData();
    formData.append('id', document.querySelector('#editFormId').value);
    formData.append('name', document.querySelector('#editFormName').value);
    formData.append('price', document.querySelector('#editFormPrice').value);
    formData.append('seats', document.querySelector('#editFormSeats').value);
    formData.append('startDate', document.querySelector('#editFormStartDate').value);
    formData.append('endDate', document.querySelector('#editFormEndDate').value);
    const pictureInput = document.querySelector('#editFormPicture');
    if (pictureInput.files.length > 0) {
        formData.append('picture', pictureInput.files[0]);
    }

    fetch('/editResturantDetails/updateRestaurantDetails', {
        method: 'POST',
        body: formData,
    })
    .then(response => {
        if (response.ok && response.headers.get("Content-Type").includes("application/json")) {
            return response.json();
        } else {
            throw new Error('Non-JSON response received');
        }
    })
    .then(data => {
        console.log(data);
        closeModal();
    })
    .catch(error => console.error('Error:', error));
    
}







