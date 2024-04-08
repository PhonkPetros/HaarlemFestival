document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var earliestStartDate = structuredOrderedItems.reduce(function (prev, curr) {
        return prev.date < curr.date ? prev : curr;
    }).date;

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
        initialView: 'timeGridWeek',
        initialDate: earliestStartDate,
        validRange: {
            start: earliestStartDate,
       
        },
        events: calendarEvents,
        eventClick: function (info) {
            var eventProps = info.event.extendedProps;
            var start = new Date(info.event.start).toLocaleString();
        
            var detailsHtml = `<strong>Event Name:</strong> ${info.event.title}<br>
        <strong>Location:</strong> ${eventProps.location}<br>
        <strong>Start:</strong> ${start}`;
        
            var successPopupContent = document.getElementById('successPopupContent');
            successPopupContent.querySelector('h3').textContent = info.event.title;
            successPopupContent.querySelector('p').innerHTML = detailsHtml;
      
            var successPopup = new bootstrap.Modal(document.getElementById('successPopup'));
            successPopup.show();
        },
        
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        }
    });
    calendar.render();
});
