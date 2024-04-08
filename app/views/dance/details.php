

<?php
include __DIR__ . '/../general_views/navbar.php';
?>

<script>
    const artistDetails = <?php echo json_encode($artistDetails); ?>;
</script>

<div class="dance-detail">
    <?php
        $formattedDates = [];
        $month = '';
        foreach ($artistDetails as $event) {
            $date = new DateTime($event["dateTime"]);
            $day = $date->format('d');
            $formattedDates[] = $day;
            
            if ($month === '') {
                $month = $date->format('F');
            }
        }

        $eventDates = implode(', ', $formattedDates) . ' ' . $month;
    ?>
    <div class="artist-details">
        <div class="artist-name"><?php echo $artistDetails[0]["artistName"] ?></div>
        <div class="artist-dates"><?php echo $eventDates ?></div>
    </div>
    <img src="<?php echo $artistDetails[0]["image1"] ?>" width="100%" alt="">
    <div class="artist-description"><?php echo $artistDetails[0]["description"] ?></div>
    <img src="<?php echo $artistDetails[0]["image2"] ?>" width="100%" alt="">
    <video src="<?php echo $artistDetails[0]["video"] ?>" width="100%" autoplay muted></video>
    <img src="<?php echo $artistDetails[0]["image3"] ?>" width="100%" alt="">

    <iframe class="spotify-embed" style="border-radius:12px" src="https://open.spotify.com/embed/<?php echo $artistDetails[0]["album"] ?>?utm_source=generator" width="500" height="500" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>

    <div class="artist-events">
        <?php foreach($artistDetails as $event): ?>
            <?php
                $date = new DateTime($event["dateTime"]);
                $eventTime = $date->format('d F Y - H:i'); 
            ?>
            <div class="event" style="background-image: url('<?php echo $event["venuePicture"] ?>')">
                <div class="event-time"><?php echo $eventTime ?></div>
                <div class="event-venue">
                    <div><?php echo $event["venueName"] ?></div>
                    <div><?php echo $event["location"] ?></div>
                </div>
                <div class="event-pricing">
                    <div>€<?php echo $event["price"] ?> / show</div>
                    <div>€<?php echo $event["oneDayPrice"] ?> / All day pass</div>
                    <div>€<?php echo $event["allDaysPrice"] ?> / Fri, Sat, Sun pass</div>
                </div>

                <div class="btn-choose-ticket" data-event-id="<?php echo $event["event_id"] ?>">Choose Ticket</div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
include __DIR__ . '/../reservation-form/dance-reservation-form.php';

include __DIR__ . '/../general_views/footer.php';
?>