<div>
  <style>
    .header-background1 {
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/img/bannerimage.jpg') no-repeat center center;
      background-size: cover
    }

    .header-background2 {
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/img/bannerdescription.jpg') no-repeat center center;
      background-size: cover
    }

    .header-background3 {
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/img/routetourbackground.png') no-repeat center center;
      background-size: cover
    }
  </style>
  <div>
    <?php foreach ($contentData as $index => $sectionData): ?>
      <?php if ($index === 0): ?>
        <div class='text-white text-center py-5 header-background1'>
          <?= ($sectionData['content']) ?>
        </div>
      <?php elseif ($index === 1): ?>
        <div class='text-white p-5 header-background2'>
          <?= ($sectionData['content']) ?>
        </div>
      <?php elseif ($index === 2): ?>
        <div class='bg-light text-dark text-center p-3'>
          <?= ($sectionData['content']) ?>
        </div>
      <?php elseif ($index === 3): ?>
        <div class='text-center text-white p-3 header-background3'><img
            src='/img/uploads/<?= htmlspecialchars($sectionData['image']) ?>' alt='Tour Route Map' class='img-fluid'></div>
      <?php elseif ($index === 4): ?>
        <div class='bg-light text-dark text-center p-3'>
          <?= ($sectionData['content']) ?>
        </div>
      <?php else: ?>
        <?php
        $carouselItemsHtml = '';
        foreach ($carouselItems['carouselItems'] as $carouselIndex => $carouselItem) {
          $activeClass = $carouselIndex === 0 ? 'active' : '';
          $carouselItemsHtml .= "<div class='carousel-item {$activeClass}'><img src='/img/{$carouselItem}' alt='' style='width: 70%; height: 600px; object-fit: cover; display: block; margin: auto;'></div>";
        }
        $controlsHtml = count($carouselItems['carouselItems']) > 1 ? '<a class="carousel-control-prev" href="#locationsCarousel" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#locationsCarousel" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a>' : '';
        ?>
        <div class='bg-dark text-white p-3'>
          <div id='locationsCarousel' class='carousel slide' data-ride='carousel'>
            <div class='carousel-inner' role='listbox'>
              <?= $carouselItemsHtml ?>
            </div>
            <?= $controlsHtml ?>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>

    <div class="text-center p-3 bg-light">
      <h2>Schedule</h2>
    </div>

    <div class="p-5"
      style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/img/scheduleimage.jpg') no-repeat center center; background-size: cover; ">
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