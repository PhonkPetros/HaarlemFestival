
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

    if(closeAddTimeslotModalBtn) {
        closeAddTimeslotModalBtn.addEventListener('click', function () {
            addTimeslotModal.style.display = 'none';
        });
    }

    if(closeEditEventDetailsModalBtn) {
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
    var editEventForm = document.getElementById('editEventForm');

    addTimeslotForm.addEventListener('submit', function (event) {
        event.preventDefault();
        let formData = new FormData(addTicketForm);
        formData.append('event_id', eventId);

        fetch('/editDetailsHistory/addNewTimeSlot', {
            method: 'POST',
            body: formData
        })
            .then(response => response.ok ? window.location.reload() : Promise.reject('Failed with status: ' + response.status))
            .catch(error => console.error('Fetch error:', error));
    });

    editEventForm.addEventListener('submit', function (event){
        event.preventDefault();
        let formData = new FormData(editEventForm);
        formData.append('event_id', eventId);

        fetch('/editDetailsHistory/editEventDetails', {
            method: 'POST',
            body: formData
        })
        .then(response => response.ok ? window.location.reload() : Promise.reject('Failed with status: ' + response.status))
        .catch(error => console.error('Fetch error:', error));
    })
});
