<div>
  <div>
    <div class="text-white text-center py-5"
      style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/img/bannerimage.jpg') no-repeat center center; background-size: cover;">
      <h1>A Stroll through History</h1>
    </div>

    <div class="text-white p-5"
      style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/img/bannerdescription.jpg') no-repeat center center; background-size: cover;">

      <p>Explore the charm of Haarlem like never before! Join us for a captivating guided tour through the heart of this
        ancient city, unveiling its rich and turbulent history. Immerse yourself in the stories of historic landmarks
        and discover the essence of Haarlem's captivating past. Don't miss this chance to "look and feel" the heritage
        that makes Haarlem truly extraordinary!</p>

    </div>

    <div class="bg-light text-dark text-center p-3">
      <h2>Tour Information</h2>
    </div>


    <div class="text-center text-white p-3"
      style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/img/routetourbackground.png') no-repeat center center; background-size: cover;">
      <img src="/img/route.png" alt="Tour Route Map" class="img-fluid">
    </div>


    <div class="bg-light text-dark text-center p-3">
      <h2>Tour Information</h2>
    </div>

    <div class="bg-dark text-white p-3">
      <div id="locationsCarousel" class="carousel slide" data-ride="carousel">

        <div class="carousel-inner" role="listbox">
          <div class="carousel-item active">
            <img src="/img/1.jpg" alt="Church of St. Bavo" class="d-block w-100">
            <div class="carousel-caption d-none d-md-block">
              <h5>Church of St. Bavo</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="/img/2.jpg" alt="Grote Markt" class="d-block w-100">
            <div class="carousel-caption d-none d-md-block">
              <h5>Grote Markt</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="/img/3.jpg" alt="De Hallen" class="d-block w-100">
            <div class="carousel-caption d-none d-md-block">
              <h5>De Hallen</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="/img/4.jpg" alt="Proveniershof" class="d-block w-100">
            <div class="carousel-caption d-none d-md-block">
              <a href="/?pageid=6">
                <h5>Proveniershof</h5>
              </a>
            </div>
          </div>
          <div class="carousel-item">
            <img src="/img/5.jpg" alt="Jopenkerk" class="d-block w-100">
            <div class="carousel-caption d-none d-md-block">
              <h5>Jopenkerk</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="/img/6.jpg" alt="Waalse Kerk Haarlem" class="d-block w-100">
            <div class="carousel-caption d-none d-md-block">
              <h5>Waalse Kerk Haarlem</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="/img/7.jpg" alt="Molen deAdriaan" class="d-block w-100">
            <div class="carousel-caption d-none d-md-block">
              <h5>Molen deAdriaan</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="/img/8.jpg" alt="Amsterdamse Poort" class="d-block w-100">
            <div class="carousel-caption d-none d-md-block">
              <h5>Amsterdamse Poort</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="/img/9.jpg" alt="Hof van Bakenes" class="d-block w-100">
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

    <div class="text-center p-3 bg-light">
      <h2>Schedule</h2>
    </div>

    <div class="p-5"
      style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/img/scheduleimage.jpg') no-repeat center center; background-size: cover;">
      <?php foreach ($structuredTickets as $language => $dates): ?>
        <h3 class="text-uppercase text-white">
          <?php echo htmlspecialchars($language); ?>
        </h3>
        <div class="table-responsive">
          <table class="table table-bordered text-center">
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
                    <td>
                      <div class="slot-container" style="min-width: 120px;">
                        <?php if (isset($times[$timeSlot]) && $times[$timeSlot] > 0): ?>
                          <div class="slot-number">
                            <?php echo $times[$timeSlot] . ' slots'; ?>
                          </div>
                          <button class="btn btn-primary btn-block btn-reserve"
                            data-event-id="<?= htmlspecialchars($eventId) ?>">Reserve</button>
                        <?php else: ?>
                          <div class="slot-number">&mdash;</div>
                        <?php endif; ?>
                      </div>
                    </td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <?php include __DIR__ . '/../general_views/footer.php'; ?>