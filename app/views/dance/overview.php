<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Darumadrop+One&display=swap" rel="stylesheet">
    <title>HAARLEM FESTIVALS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/danceOverview.css">
    <link rel="stylesheet" href="/css/footer.css">
</head>

<?php
include __DIR__ . '/../general_views/navbar.php';
?>
<?php foreach ($contentData as $index => $sectionData): ?>

    <div class="eventProperties">
        <?php if ($index === 0): ?>
            <?= ($sectionData['content']) ?>

        </div>

        <div class="highlightContainer">
            <?php foreach ($artists as $artist): ?>
                <a href="/dance/?artist=<?= $artist['artistId'] ?>"><img src="<?= $artist['profile'] ?>" width="250px" alt=""></a>
            <?php endforeach; ?>
            <!-- <img src="/img/nickiHighlight.png" width="250px" alt="">
            <img src="/img/tiestoHighlight.png" width="250px" alt="">
            <img src="/img/hardwellHighlight.png" width="250px" alt="">
            <img src="/img/afroHighlight.png" width="250px" alt="">
            <img src="/img/arminHighlight.png" width="250px" alt="">
            <img src="/img/martinHighlight.png" width="250px" alt=""> -->
        </div>

    <?php elseif ($index === 1): ?>
        <?= ($sectionData['content']) ?>
    <?php endif; ?>
<?php endforeach; ?>




<div class="ticketAdvertisement"> <img src="/img/ticketAdvertisement.png" width="100%" alt=""> </div>
<div class="jazzAdvertisement"> <img src="/img/jazzAdvertisement.png" width="100%" alt=""> </div>

<?php
include __DIR__ . '/../general_views/footer.php';
?>