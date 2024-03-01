<div>
  <div class="tour-header">
    <h1>A Stroll through History</h1>
  </div>

  <div class="tour-info">
    <p>Explore the charm of Haarlem like never before! Join us for a captivating guided tour through the heart of this
      ancient city, unveiling its rich and turbulent history. Immerse yourself in the stories of historic landmarks and
      discover the essence of Haarlem's captivating past. Don't miss this chance to "look and feel" the heritage that
      makes Haarlem truly extraordinary!</p>
  </div>

  <div class="tour-information">
    <h2>Tour Information</h2>
  </div>
  <div class="tour-information-text">
    <p>Tour can be taken in 3 languages: English, Dutch and Chinese. Duration of this walking tour will be approx. 2.5
      hours (with a 15-minute break with refreshments). The tour starts near of the ‘Church of St.Bavo’, ‘GroteMarkt’ in
      the centre of Haarlem. A giant flag will mark the exact starting location. Due to the nature of this walk
      participants must be a minimum of 12 years old and no strollers are allowed. Groups will consist of 12
      participants + 1 guide. Prices (tour including one (1) drink p.p.): • Regular Participant: € 17,50 • Family ticket
      (max. 4 participants): € 60</p>
  </div>

  <div class="tour-information">
    <h2>Route of the tour</h2>
  </div>
  <div class="tour-route">
    <img src="/img/route.png" alt="Tour Route Map" class="img-fluid">
  </div>

  <div class="tour-information">
    <h2>Locations of the tour</h2>
  </div>

  <div class="tour-locations">
    <div id="locationsCarousel" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="/img/1.jpg" alt="Church of St. Bavo">
          <div class="carousel-caption d-none d-md-block">
            <a href="/history/churchbravo">
              <h5>Church of St. Bavo</h5>
            </a>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/img/2.jpg" alt="Grote Markt">
          <div class="carousel-caption d-none d-md-block">
            <h5>Grote Markt</h5>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/img/3.jpg" alt="De Hallen">
          <div class="carousel-caption d-none d-md-block">
            <h5>De Hallen</h5>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/img/4.jpg" alt="Proveniershof">
          <div class="carousel-caption d-none d-md-block">
            <a href="/history/proveniershof">
              <h5>Proveniershof</h5>
            </a>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/img/5.jpg" alt="Jopenkerk">
          <div class="carousel-caption d-none d-md-block">
            <h5>Jopenkerk</h5>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/img/6.jpg" alt="Waalse Kerk Haarlem">
          <div class="carousel-caption d-none d-md-block">
            <h5>Waalse Kerk Haarlem</h5>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/img/7.jpg" alt="Molen deAdriaan">
          <div class="carousel-caption d-none d-md-block">
            <h5>Molen deAdriaan</h5>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/img/8.jpg" alt="Amsterdamse Poort">
          <div class="carousel-caption d-none d-md-block">
            <h5>Amsterdamse Poort</h5>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/img/9.jpg" alt="Hof van Bakenes">
          <div class="carousel-caption d-none d-md-block">
            <h5>Hof van Bakenes</h5>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#locationsCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#locationsCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
  <div class="tour-information">
    <h2 class="text-center">Schedule</h2>
  </div>
  <div class="tour-schedule">
    <?php foreach ($structuredTickets as $language => $dates): ?>
      <h3>
        <?php echo strtoupper(htmlspecialchars($language)); ?>
      </h3>
      <table class="table schedule-table">
        <thead>
          <tr>
            <th>Date</th>
            <?php foreach ($uniqueTimes as $time): ?>
              <th>
                <?php echo htmlspecialchars($time); ?>
              </th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($dates as $date => $times): ?>
            <tr>
              <td>
                <?php echo htmlspecialchars($date); ?>
              </td>
              <?php foreach ($uniqueTimes as $timeSlot): ?>
                <?php if (isset($times[$timeSlot]) && $times[$timeSlot] > 0): ?>
                  <td>
                    <?php echo $times[$timeSlot] . ' group'; ?> <button class="btn btn-primary btn-reserve" data-event-id="<?= htmlspecialchars($eventId) ?>">Reserve</button>
                  </td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endforeach; ?>
  </div>
</div>

<?php
include __DIR__ . '/../general_views/footer.php';
?>
