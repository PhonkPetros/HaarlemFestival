document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('ticketModal');
    var openModalBtn = document.getElementById('openModal');
    var closeModalBtn = document.getElementById('closeModal');
    var addTicketForm = document.getElementById('addTicketForm');

    openModalBtn.addEventListener('click', function() {
        modal.style.display = 'block';
    });

    closeModalBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

    var eventId; 

    openModalBtn.addEventListener('click', function() {
        modal.style.display = 'block';
        eventId = this.getAttribute('data-event-id'); 
    });
    
    addTicketForm.addEventListener('submit', function(event) {
        event.preventDefault(); 
        let formData = new FormData(addTicketForm);
        formData.append('event_id', eventId); 
    
        fetch('/manage-event-details/editDetailsHistory/addNewTimeSlot', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok. Status Code: ' + response.status);
            }
            window.location.reload();
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    });
});
