let calA = new Calendar({
    id: "#calendar-a",
    theme: "basic",
    weekdayType: "long-upper",
    calendarSize: "small",
    dateChanged: (currentDate, events) => {
        var date = new Date(currentDate);
        document.getElementById("selected-date").innerHTML = formatDate(date);
    }
});

function formatDate(date) {
    var months = [
        "January", "February", "March", "April", "May", "June", "July",
        "August", "September", "October", "November", "December"
    ];
    var day = date.getDate();
    var monthIndex = date.getMonth();
    return day + ' ' + months[monthIndex];
}