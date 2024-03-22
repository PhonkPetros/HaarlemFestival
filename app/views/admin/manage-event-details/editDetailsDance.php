<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<script>
    const danceEvents = [];
    <?php foreach ($danceEvents as $event): ?>
        <?php $eventJson = $event->jsonSerialize() ?>
        danceEvents.push(<?= json_encode($eventJson) ?>);
    <?php endforeach; ?>

    const artists = [];
    <?php foreach ($artists as $artist): ?>
        artists.push(<?= json_encode($artist) ?>);
    <?php endforeach; ?>

    const venues = [];
    <?php foreach ($venues as $venue): ?>
        venues.push(<?= json_encode($venue) ?>);
    <?php endforeach; ?>
</script>
<h1>Edit Dance Event Details</h1>
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-center">
                    <u>Venues</u>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary editVenueDetailsButton"
                        data-venue-id="">Create New Venue</button>
                    <?php foreach ($venues as $venue): ?>
                        <div class="dance-event">
                            <img src="<?= htmlspecialchars($venue["picture"]) ?>" alt="" width="100px" height="100px">
                            <div class="dance-event-information">
                                <h5 class="card-title">
                                    <?= htmlspecialchars($venue["name"]) ?>
                                </h5>
                                <p class="card-text"><strong>Address:</strong>
                                    <?= htmlspecialchars($venue["location"]) ?>
                                </p>
                                <button type="button" class="btn btn-primary editVenueDetailsButton"
                                    data-venue-id="<?= htmlspecialchars($venue["venueId"]) ?>">Edit Venue Details</button>
                                <button type="button" class="btn btn-primary deleteVenueButton"
                                    data-venue-id="<?= htmlspecialchars($venue["venueId"]) ?>">Delete Venue</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-center">
                    <u>Event Details</u>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary editEventDetailsButton"
                        data-event-id="">Create New Event</button>
                    <?php foreach ($danceEvents as $event): ?>
                        <div class="dance-event">
                            <img src="<?= htmlspecialchars($event->getImage()) ?>" alt="" width="100px" height="100px">
                            <div class="dance-event-information">
                                <h5 class="card-title">
                                    <?= htmlspecialchars($event->getVenue()) ?>
                                    <span>-</span>
                                    <?= htmlspecialchars($event->getFormattedDateTime()) ?>
                                </h5>
                                <!-- <p class="card-text"><strong>Address:</strong>
                                    <?= htmlspecialchars($event->getAddress()) ?>
                                </p> -->
                                <p class="card-text"><strong>Price:</strong>
                                    €<?= htmlspecialchars($event->getPrice()) ?>
                                </p>
                                <p class="card-text"><strong>One Day Price:</strong>
                                    €<?= htmlspecialchars($event->getOneDayPrice()) ?>
                                </p>
                                <p class="card-text"><strong>All Days Price:</strong>
                                    €<?= htmlspecialchars($event->getAllDaysPrice()) ?>
                                </p>
                                <p class="card-text"><strong>Artists:</strong>
                                    <?php echo $event->getArtistsAsString(); ?>
                                </p>
                                <button type="button" class="btn btn-primary editEventDetailsButton"
                                    data-event-id="<?= htmlspecialchars($event->getDanceEventId()) ?>">Edit Event Details</button>
                                <button type="button" class="btn btn-primary deleteEventButton"
                                    data-event-id="<?= htmlspecialchars($event->getDanceEventId()) ?>">Delete Event</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-center">
                    <u>Artists</u>
                </div>
                <div class="overflow-auto" style="max-height: 770px;">
                    <div class="card-body ">
                        <button type="button" class="btn btn-primary editArtistDetailsButton"
                            data-artist-id="">Add New Artist</button>
                        <?php if (empty ($artists)): ?>
                            <p>No Artists Available</p>
                        <?php else: ?>
                            <?php foreach ($artists as $artist): ?>
                                <div class="dance-event">
                                    <img src="<?= htmlspecialchars($artist["profile"]) ?>" alt="" width="100px" height="100px">
                                    <div class="dance-event-information">
                                        <h5 class="card-title">
                                            <?= htmlspecialchars($artist["name"]) ?>
                                        </h5>
                                        <button type="button" class="btn btn-primary editArtistDetailsButton"
                                            data-artist-id="<?= htmlspecialchars($artist["artistId"]) ?>">Edit Artist Details</button>
                                        <button type="button" class="btn btn-primary deleteArtistButton"
                                            data-artist-id="<?= htmlspecialchars($artist["artistId"]) ?>">Delete Artist</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-danger" style="margin-bottom: 20px" onclick="window.history.back();">Go Back</button>
</div>

<div id="venueDetailsModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Venue Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 venue-img"></div>
                <div class="mb-3">
                    <label for="venue-image" class="form-label">Venue Image</label>
                    <input type="file" class="form-control" id="venue-image" name="venue-image" accept=".jpg, .jpeg, .png">
                </div>
                <div class="mb-3">
                    <label for="venue-name" class="form-label">Venue Name</label>
                    <input type="text" class="form-control" id="venue-name" name="venue-name">
                </div>
                <div class="mb-3">
                    <label for="venue-address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="venue-address" name="venue-address">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-venue-save">Save</button>
            </div>
        </div>
    </div>
</div>

<div id="eventDetailsModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 event-img">
                    
                </div>
                <div class="mb-3">
                    <label for="choose-image" class="form-label">Event Image</label>
                    <input type="file" class="form-control" id="choose-image" name="image" accept=".jpg, .jpeg, .png">
                </div>
                <div class="mb-3">
                    <label for="venue" class="form-label">Venue</label>
                    <select name="venues" id="venue">
                        <?php foreach($venues as $venue): ?>
                            <option value="<?php echo $venue["venueId"]?>"><?php echo $venue["name"]?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="dateTime" class="form-label">Date and Time</label>
                    <input type="datetime-local" class="form-control" id="dateTime" name="dateTime">
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price">
                </div>
                <div class="mb-3">
                    <label for="oneDayPrice" class="form-label">One Day Price</label>
                    <input type="number" class="form-control" id="oneDayPrice" name="oneDayPrice">
                </div>
                <div class="mb-3">
                    <label for="allDaysPrice" class="form-label">All Days Price</label>
                    <input type="number" class="form-control" id="allDaysPrice" name="allDaysPrice">
                </div>
                <div class="mb-3 checkbox-artists">
                    <label for="price" class="form-label">Artists</label>
                    <?php foreach($artists as $artist): ?>
                        <label><input type="checkbox" name="artists" value="<?php echo $artist["artistId"]?>"> <?php echo $artist["name"]?></label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-event-save">Save</button>
            </div>
        </div>
    </div>
</div>

<div id="artistDetailsModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Artist Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 artist-img" id="view-artist-image-pp"></div>
                <div class="mb-3">
                    <label for="artist-image-pp" class="form-label">Artist Profile Picture</label>
                    <input type="file" class="form-control" id="artist-image-pp" name="artistImagePP" accept=".jpg, .jpeg, .png">
                </div>
                <div class="mb-3">
                    <label for="artistName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="artistName" name="artistName">
                </div>
                <div class="mb-3">
                    <label for="artistDescription" class="form-label">Description</label>
                    <input type="text" class="form-control" id="artistDescription" name="artistDescription">
                </div>
                <div class="mb-3 artist-img" id="view-artist-image-1"></div>
                <div class="mb-3">
                    <label for="artist-image-1" class="form-label">Artist Picture 1</label>
                    <input type="file" class="form-control" id="artist-image-1" name="artistImage1" accept=".jpg, .jpeg, .png">
                </div>
                <div class="mb-3 artist-img" id="view-artist-image-2"></div>
                <div class="mb-3">
                    <label for="artist-image-2" class="form-label">Artist Picture 2</label>
                    <input type="file" class="form-control" id="artist-image-2" name="artistImage2" accept=".jpg, .jpeg, .png">
                </div>
                <div class="mb-3 artist-img" id="view-artist-image-3"></div>
                <div class="mb-3">
                    <label for="artist-image-3" class="form-label">Artist Picture 3</label>
                    <input type="file" class="form-control" id="artist-image-3" name="artistImage3" accept=".jpg, .jpeg, .png">
                </div>
                <video class="artist-video" id="view-artist-video" src="" width="100%"></video>
                <div class="mb-3">
                    <label for="artist-video" class="form-label">Artist Video (5MB max)</label>
                    <input type="file" class="form-control" id="artist-video" name="artistVideo" accept=".mp4">
                </div>
                <div class="mb-3">
                    <label for="artist-album" class="form-label">Spotify URL</label>
                    <input type="text" class="form-control" id="artist-album" name="artistAlbum" placeholder="https://open.spotify.com/album/1FOJ5IXGXe8dl0cXvCU6wK">
                </div>
                <div class="spotify-embed"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-artist-save">Save</button>
            </div>
        </div>
    </div>
</div>

<script src="/js/editDetailsDance.js"></script>
<?php include __DIR__ . '/../../general_views/footer.php'; ?>