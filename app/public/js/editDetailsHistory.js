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
                throw new Error('Network response was not ok.');
            }
            return response.json();
        })
        .then(data => {
            swal("New Timeslot added", "", "success").then(() => {
                window.location.reload();
            });
        })
        .catch(error => {
            console.error('Fetch error:', error);
            swal("Error", error.message, "error");
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
                throw new Error('Network response was not ok.');
            }
            return response.json();
        })
        .then(data => {
            swal("Event Details Edited Successfully", "", "success").then(() => {
                window.location.reload();
            });
        })
        .catch(error => {
            console.error('Fetch error:', error);
            swal("Error", "Error: " + error.message, "error");
        });
    });

    var deleteTimeslotButtons = document.querySelectorAll('.deleteTimeslotButton');
    deleteTimeslotButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var ticketId = this.getAttribute('data-ticket-id');
            swal({
                title: "Are you sure?",
                text: `Do you want to delete timeslot ${ticketId}?`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    let formData = new FormData();
                    formData.append('ticket_id', ticketId);

                    fetch('/editDetailsHistory/deleteTimeSlot', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        swal(`Timeslot ${ticketId} deleted successfully.`, {
                            icon: "success",
                        }).then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        swal("Error", "Error deleting timeslot.", "error");
                    });
                }
            });
        });
    });
});
