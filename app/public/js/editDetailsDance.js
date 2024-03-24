document.addEventListener('DOMContentLoaded', function () {
    const eventDetailsModal = document.getElementById('eventDetailsModal');

    $(document).on('click', '.editEventDetailsButton', function (e) {
        const eventId = e.target.getAttribute('data-event-id');
        eventDetailsModal.setAttribute('data-event-id', eventId);
        eventDetailsModal.style.display = 'block';
        loadEventDetails(eventId);
    });

    $(document).on('click', '.modal .btn-close', function (e) {
        e.target.closest('.modal').style.display = 'none';
    });

    $(document).on('click', '.btn-event-save', function (e) {
        saveEventDetails();
    });
});

function loadEventDetails(eventId) {
    const event = danceEvents.find(event => event.id == eventId);

    if (!event) {
        const eventDetailsModal = document.getElementById('eventDetailsModal');
        eventDetailsModal.setAttribute('data-event-id', "");
        $("#venue").val("");
        $("#address").val("");
        $("#dateTime").val("");
        $("#price").val("");
        return;
    }

    $("#venue").val(event.venue);
    $("#address").val(event.address);
    $("#dateTime").val(event.dateTime);
    $("#price").val(event.price);
}

function saveEventDetails() {
    const eventDetailsModal = document.getElementById('eventDetailsModal');
    const eventId = eventDetailsModal.getAttribute('data-event-id');
    const venue = $("#venue").val();
    const address = $("#address").val();
    const dateTime = $("#dateTime").val();
    const price = $("#price").val();

    const formData = new FormData();
    formData.append('venue', venue);
    formData.append('address', address);
    formData.append('dateTime', dateTime);
    formData.append('price', price);
    formData.append('image', "/img/MartinGarrix.png");

    if (eventId != "") {
        formData.append('danceEventId', eventId);
        fetch('/dance/updateEvent', {
            method: 'POST',
            body: formData
        })
        .then(data => {
            window.location.reload();
        });
    } else {
        fetch('/dance/addNewEvent', {
            method: 'POST',
            body: formData
        })
        .then(data => {
            window.location.reload();
        });
    }

    
}