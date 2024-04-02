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