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
                    <?php if (isset ($times[$timeSlot]) && $times[$timeSlot]['quantity'] > 0): ?>
                      <div class="slot-number">
                        <?php echo $times[$timeSlot]['quantity'] . ' slots'; ?>
                      </div>
                      <div class="slot-price">
                        <?php echo 'Price: ' . htmlspecialchars($times[$timeSlot]['price']); ?>
                      </div>
                      <button class="btn btn-primary btn-block btn-reserve"
                        data-ticket-id="<?= htmlspecialchars($times[$timeSlot]['ticket_id']) ?>"
                        data-event-id="<?= htmlspecialchars($times[$timeSlot]['event_id']) ?>"
                        data-price="<?= htmlspecialchars($times[$timeSlot]['price']) ?>"
                        data-date="<?= htmlspecialchars($times[$timeSlot]['date']) ?>"
                        data-time="<?= htmlspecialchars($times[$timeSlot]['time']) ?>"
                        data-endtime="<?= htmlspecialchars(date('H:i', strtotime($times[$timeSlot]['endtime']))) ?>"
                        data-language="<?= htmlspecialchars($times[$timeSlot]['language']) ?>"
                        data-location="<?= htmlspecialchars($times[$timeSlot]['location']) ?>">
                        Reserve
                      </button>
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


<?php require_once __DIR__ . '/../../views/reservation-form/popup-reservation-form.php' ?>