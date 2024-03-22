document.addEventListener('DOMContentLoaded', function () {
    const eventDetailsModal = document.getElementById('eventDetailsModal');
    const artistDetailsModal = document.getElementById('artistDetailsModal');

    $(document).on('click', '.editEventDetailsButton', function (e) {
        const eventId = e.target.getAttribute('data-event-id');
        eventDetailsModal.setAttribute('data-event-id', eventId);
        eventDetailsModal.style.display = 'block';
        loadEventDetails(eventId);
    });

    $(document).on('click', '.editArtistDetailsButton', function (e) {
        const artistId = e.target.getAttribute('data-artist-id');
        artistDetailsModal.setAttribute('data-artist-id', artistId);
        artistDetailsModal.style.display = 'block';
        loadArtistDetails(artistId);
    });

    $(document).on('click', '.editVenueDetailsButton', function (e) {
        const venueId = e.target.getAttribute('data-venue-id');
        const venueDetailsModal = document.getElementById('venueDetailsModal');
        venueDetailsModal.setAttribute('data-venue-id', venueId);
        venueDetailsModal.style.display = 'block';
        loadVenueDetails(venueId);
    });

    $(document).on('click', '.modal .btn-close', function (e) {
        e.target.closest('.modal').style.display = 'none';
    });

    $(document).on('click', '.btn-event-save', function (e) {
        saveEventDetails();
    });

    $(document).on('click', '.btn-artist-save', function (e) {
        saveArtistDetails();
    });

    $(document).on('click', '.btn-venue-save', function (e) {
        saveVenueDetails();
    });

    $(document).on('click', '.deleteEventButton', function (e) {
        const eventId = e.target.getAttribute('data-event-id');
        const formData = new FormData();
        formData.append('danceEventId', eventId);
        fetch(`/dance/deleteEvent`, {
            method: 'POST',
            body: formData
        })
        .then(data => {
            window.location.reload();
        });
    });

    $(document).on('click', '.deleteArtistButton', function (e) {
        const artistId = e.target.getAttribute('data-artist-id');
        const formData = new FormData();
        formData.append('artistId', artistId);
        fetch(`/dance/deleteArtist`, {
            method: 'POST',
            body: formData
        })
        .then(data => {
            window.location.reload();
        });
    });

    $(document).on('click', '.deleteVenueButton', function (e) {
        const venueId = e.target.getAttribute('data-venue-id');
        const formData = new FormData();
        formData.append('venueId', venueId);
        fetch(`/dance/deleteVenue`, {
            method: 'POST',
            body: formData
        })
        .then(data => {
            window.location.reload();
        });
    });

});

function loadEventDetails(eventId) {
    const event = danceEvents.find(event => event.id == eventId);

    if (!event) {
        const eventDetailsModal = document.getElementById('eventDetailsModal');
        eventDetailsModal.setAttribute('data-event-id', "");
        $(".event-img")[0].style.backgroundImage = `url('')`;
        $("#venue").val("");
        $("#address").val("");
        $("#dateTime").val("");
        $("#price").val("");
        $("#oneDayPrice").val("");
        $("#allDaysPrice").val("");

        const artistCheckboxes = document.querySelectorAll('.checkbox-artists input[name="artists"]');
        artistCheckboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
        return;
    }

    $(".event-img")[0].style.backgroundImage = `url('${event.image}')`;
    $("#venue").val(event.venueId);
    $("#address").val(event.address);
    $("#dateTime").val(event.dateTime);
    $("#price").val(event.price);
    $("#oneDayPrice").val(event.oneDayPrice);
    $("#allDaysPrice").val(event.allDaysPrice);

    const artistCheckboxes = document.querySelectorAll('.checkbox-artists input[name="artists"]');
    artistCheckboxes.forEach(function(checkbox) {
        if (event.artists.some(artist => artist.id == checkbox.value)) {
            checkbox.checked = true;
        } else {
            checkbox.checked = false;
        }
    });
}

function saveEventDetails() {
    const eventDetailsModal = document.getElementById('eventDetailsModal');
    const eventId = eventDetailsModal.getAttribute('data-event-id');
    const image = $("#choose-image")[0];
    const venue = $("#venue").val();
    const dateTime = $("#dateTime").val();
    const price = $("#price").val();
    const oneDayPrice = $("#oneDayPrice").val();
    const allDaysPrice = $("#allDaysPrice").val();

    const artistCheckboxes = document.querySelectorAll('.checkbox-artists input[name="artists"]:checked');
    const selectedArtists = [];
    artistCheckboxes.forEach(function(checkbox) {
        selectedArtists.push(checkbox.value);
    });

    const formData = new FormData();
    formData.append('venue', venue);
    formData.append('dateTime', dateTime);
    formData.append('price', price);
    formData.append('oneDayPrice', oneDayPrice);
    formData.append('allDaysPrice', allDaysPrice);
    if (image.files.length > 0) {
        formData.append('image', image.files[0]);
    }
    formData.append('artists', selectedArtists.join(','));

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

function loadArtistDetails(artistId) {
    const artistDetailsModal = document.getElementById('artistDetailsModal');
    const artist = artists.find(artist => artist.artistId == artistId);

    $("#view-artist-image-pp")[0].style.backgroundImage = `url('')`;
    $("#view-artist-image-pp")[0].style.display = "none";

    $("#artistName").val("");
    $("#artistDescription").val("");

    $("#view-artist-image-1")[0].style.backgroundImage = `url('')`;
    $("#view-artist-image-1")[0].style.display = "none";
    $("#artist-image-1").val("");

    $("#view-artist-image-2")[0].style.backgroundImage = `url('')`;
    $("#view-artist-image-2")[0].style.display = "none";
    $("#artist-image-2").val("");

    $("#view-artist-image-3")[0].style.backgroundImage = `url('')`;
    $("#view-artist-image-3")[0].style.display = "none";
    $("#artist-image-3").val("");

    $("#view-artist-video")[0].src = "";
    $("#view-artist-video")[0].style.display = "none";
    $("#artist-video").val("");

    $("#artist-album").val("");
    
    if (!artist) {
        artistDetailsModal.setAttribute('data-artist-id', "");
        return;
    }

    $("#artistName").val(artist.name);
    $("#artistDescription").val(artist.description);

    if (artist.profile) {
        $("#view-artist-image-pp")[0].style.backgroundImage = `url('${artist.profile}')`;
        $("#view-artist-image-pp")[0].style.display = "block";
    }

    if (artist.image1) {
        $("#view-artist-image-1")[0].style.backgroundImage = `url('${artist.image1}')`;
        $("#view-artist-image-1")[0].style.display = "block";
    }

    if (artist.image2) {
        $("#view-artist-image-2")[0].style.backgroundImage = `url('${artist.image2}')`;
        $("#view-artist-image-2")[0].style.display = "block";
    }

    if (artist.image3) {
        $("#view-artist-image-3")[0].style.backgroundImage = `url('${artist.image3}')`;
        $("#view-artist-image-3")[0].style.display = "block";
    }

    if (artist.video) {
        $("#view-artist-video")[0].style.display = "block";
        $("#view-artist-video")[0].src = artist.video;
    }

    if (artist.album) {
        const spotifyEmbed = 
        `<iframe style="border-radius:12px" src="https://open.spotify.com/embed/${artist.album}?utm_source=generator" width="100%" height="152" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>`
        $(".spotify-embed").html(spotifyEmbed);
        $("#artist-album").val(`https://open.spotify.com/${artist.album}`);
    } else {
        $(".spotify-embed").html("");
        $("#artist-album").val("");
    }
}

function saveArtistDetails() {
    const artistDetailsModal = document.getElementById('artistDetailsModal');
    const artistId = artistDetailsModal.getAttribute('data-artist-id');
    const name = $("#artistName").val();
    const description = $("#artistDescription").val();
    const profile = $("#artist-image-pp")[0];
    const image1 = $("#artist-image-1")[0];
    const image2 = $("#artist-image-2")[0];
    const image3 = $("#artist-image-3")[0];
    const video = $("#artist-video")[0];
    const album = $("#artist-album").val();

    const formData = new FormData();
    formData.append('name', name);
    formData.append('description', description);
    if (profile.files.length > 0) {
        formData.append('profile', profile.files[0]);
    }
    if (image1.files.length > 0) {
        formData.append('image1', image1.files[0]);
    }
    if (image2.files.length > 0) {
        formData.append('image2', image2.files[0]);
    }
    if (image3.files.length > 0) {
        formData.append('image3', image3.files[0]);
    }
    if (video.files.length > 0) {
        formData.append('video', video.files[0]);
    }
    const spotifyId = album.split("https://open.spotify.com/")[1];
    formData.append('album', spotifyId);

    if (artistId != "") {
        formData.append('artistId', artistId);
        fetch('/dance/updateArtist', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            window.location.reload();
        });
    } else {
        fetch('/dance/addNewArtist', {
            method: 'POST',
            body: formData
        })
        .then(data => {
            window.location.reload();
        });
    }
}

function loadVenueDetails(venueId) {
    const venue = venues.find(venue => venue["venueId"] == venueId);

    if (!venue) {
        $("#venue-image").val("");
        $("#venue-name").val("");
        $("#venue-address").val("");
        return;
    }

    $("#venue-image")[0].style.backgroundImage = `url('${venue.image}')`;
    $("#venue-name").val(venue.name);
    $("#venue-address").val(venue.location);
}

function saveVenueDetails() {
    const venueId = $("#venueDetailsModal").attr('data-venue-id');
    const image = $("#venue-image")[0];
    const name = $("#venue-name").val();
    const address = $("#venue-address").val();

    const formData = new FormData();
    formData.append('name', name);
    formData.append('location', address);
    if (image.files.length > 0) {
        formData.append('picture', image.files[0]);
    }

    if (venueId != "") {
        formData.append('venueId', venueId);
        fetch('/dance/updateVenue', {
            method: 'POST',
            body: formData
        })
        .then(data => {
            window.location.reload();
        });
    } else {
        fetch('/dance/addNewVenue', {
            method: 'POST',
            body: formData
        })
        .then(data => {
            window.location.reload();
        });
    }
}

$(document).on('change', '#venueDetailsModal input[type=file]', function (e) {
    const img = e.target.files[0];
    const reader = new FileReader();
    reader.onload = function (e) {
        $(".venue-img")[0].style.backgroundImage = `url('${e.target.result}')`;
    }
    reader.readAsDataURL(img);
});

$(document).on('change', '#artistDetailsModal input[type=file]', function (e) {
    const img = e.target.files[0];
    const id = e.target.id;
    const reader = new FileReader();
    reader.onload = function (e) {
        $(`#view-${id}`)[0].style.backgroundImage = `url('${e.target.result}')`;
        $(`#view-${id}`)[0].style.display = "block";
    }
    reader.readAsDataURL(img);
});

$(document).on('change', '#artist-album', function (e) {
    const spotifyId = e.target.value.split("https://open.spotify.com/")[1];
    
    if (!spotifyId) {
        $(".spotify-embed").html("");
        $("#artist-album").val("");
        return;
    }

    const spotifyEmbed = 
    `<iframe style="border-radius:12px" src="https://open.spotify.com/embed/${spotifyId}?utm_source=generator" width="100%" height="152" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>`
    console.log(spotifyEmbed);

    $(".spotify-embed").html(spotifyEmbed);
});