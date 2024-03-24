document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendarEvents = structuredOrderedItems.map(function (item) {
        return {
            id: item.order_item_id,
            title: item.event_details.event_name || 'No Title',
            start: item.date + 'T' + item.start_time,
            end: item.date + 'T' + item.end_time,
            extendedProps: {
                orderId: item.order_item_id,
                location: item.location,
            }
        };
    });

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridWeek',
        initialDate: '2024-06-23',
        validRange: {
            start: '2024-06-23',
            end: '2024-07-01'
        },
        events: calendarEvents,
        eventClick: function (info) {
            var eventProps = info.event.extendedProps;
            var start = new Date(info.event.start).toLocaleString();
            var end = new Date(info.event.end).toLocaleString();
            var details = `Event Name: ${info.event.title}
Location: ${eventProps.location}
Start: ${start}
End: ${end}`;

            // Update the modal with the event details
            var successPopupContent = document.getElementById('successPopupContent');
            successPopupContent.querySelector('h3').textContent = info.event.title;
            successPopupContent.querySelector('p').textContent = details;

            // Show the modal
            var successPopup = new bootstrap.Modal(document.getElementById('successPopup'));
            successPopup.show();
        },

        headerToolbar: {
            left: '',
            center: 'title',
            right: ''
        }
    });
    calendar.render();
});
