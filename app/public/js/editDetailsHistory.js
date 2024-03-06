document.addEventListener('DOMContentLoaded', function () {
    var addTimeslotModal = document.getElementById('addTimeslotModal');
    var editEventDetailsModal = document.getElementById('editEventDetailsModal');
    var editEventDetailsButton = document.getElementById('editEventDetailsButton');
    var addTimeslotButton = document.getElementById('addTimeslotButton');
    var closeAddTimeslotModalBtn = document.querySelector('#addTimeslotModal .btn-close');
    var closeEditEventDetailsModalBtn = document.querySelector('#editEventDetailsModal .btn-close');

    editEventDetailsButton.addEventListener('click', function () {
        editEventDetailsModal.style.display = 'block';
    });

    addTimeslotButton.addEventListener('click', function () {
        addTimeslotModal.style.display = 'block';
    });


    if (closeAddTimeslotModalBtn) {
        closeAddTimeslotModalBtn.addEventListener('click', function () {
            addTimeslotModal.style.display = 'none';
        });
    }

    if (closeEditEventDetailsModalBtn) {
        closeEditEventDetailsModalBtn.addEventListener('click', function () {
            editEventDetailsModal.style.display = 'none';
        });
    }

    window.addEventListener('click', function (event) {
        if (event.target == addTimeslotModal) {
            addTimeslotModal.style.display = 'none';
        }
        if (event.target == editEventDetailsModal) {
            editEventDetailsModal.style.display = 'none';
        }
    });

    var eventId = editEventDetailsButton.getAttribute('data-event-id');
    
    var addTimeslotForm = document.getElementById('addTimeslotForm');
    addTimeslotForm.addEventListener('submit', function (event) {
        event.preventDefault();
        let formData = new FormData(this); 
        formData.append('event_id', eventId);

        fetch('/editDetailsHistory/addNewTimeSlot', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed with status: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            alert("New Timeslot added");
            window.location.reload();
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert(error.message);
        });
    });

    var editEventForm = document.getElementById('editEventForm');
    editEventForm.addEventListener('submit', function (event) {
        event.preventDefault();
        let formData = new FormData(this); 
        formData.append('event_id', eventId);

        fetch('/editDetailsHistory/editEventDetails', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed with status: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            alert("Event Details Edited Successfully");
            window.location.reload();
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert("Error: " + error.message);
        });
    });

    var deleteTimeslotButtons = document.querySelectorAll('.deleteTimeslotButton');
    deleteTimeslotButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var ticketId = this.getAttribute('data-ticket-id');
            const confirmed = confirm(`Are you sure you want to delete timeslot ${ticketId}?`);
            if (confirmed) {
                let formData = new FormData();
                formData.append('ticket_id', ticketId);

                fetch('/editDetailsHistory/deleteTimeSlot', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed with status: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    alert(`Timeslot ${ticketId} deleted successfully.`);
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting timeslot.');
                });
            }
        });
    });
});
