<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/resturant.css">
    <link rel="stylesheet" href="/css/yum.css">
</head>
<body>
<div class="div">
<?php
if ($restaurantDetails !== null) {
  $picture = $restaurantDetails->getPicture();
  var_dump($picture);
  if(empty($picture) || is_null($picture)) {
      $picture = "default.jpg";
  } else {
      $picture = htmlspecialchars($picture);
  }
} else {
  $picture = "default.jpg";
}
?>
<img src="/img/<?= $picture ?>" class="img"/>
  <div class="div-2">
    <div class="div-3">Ratatouille</div>
    <div class="div-4">
      Establishing his restaurant in 2013, the cook made his goal to serve
      French meals, with a friendly atmosphere. The success of chef Jouza
      Jaring, made the restaurant one of a kind Michelin rated restaurant.
    </div>
  </div>
</div>

<section class="cuisine-container">
  <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/0d286cbf245c9e57217c741827e1d1c8a5afd459f83c01192dfd4630a93d8270?apiKey=3023167e7a8a4e649532aa6db2acfe06&" alt="French cuisine" class="cuisine-image" />
  <h2 class="cuisine-text">The cuisine la french</h2>
</section>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-3 mb-4">
      <img src="/img/<?php echo $contentData[3]['image']?>" alt="Caviar dish" class="img-fluid">
      <div style="background-color: #ffffff; padding: 10px; margin-top: 10px;">
        <?php echo $contentData[3]['content']?>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <img src="/img/<?php echo $contentData[4]['image']?>" alt="Le dîner dish" class="img-fluid">
      <div style="background-color: #ffffff; padding: 10px; margin-top: 10px;">
       <?php echo $contentData[4]['content']?>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <img src="/img/<?php echo $contentData[5]['image']?>" alt="Le déjeuner dish" class="img-fluid">
      <div style="background-color: #ffffff; padding: 10px; margin-top: 10px;">
      <?php echo $contentData[5]['content']?>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <img src="/img/<?php echo $contentData[6]['image']?>" alt="Le repas dish" class="img-fluid">
      <div style="background-color: #ffffff; padding: 10px; margin-top: 10px;">
        <?php echo $contentData[6]['content']?>
      </div>
    </div>
  </div>
</div>

<div class="restaurant-info-wrapper">
  <div class="restaurant-info">
    <div class="restaurant-image-container">
      <img src="/img/<?php echo $contentData[7]['image']?>" alt="Restaurant Picture" class="responsive-image"> <!-- Renamed class for the image -->
    </div>
    <div class="restaurant-content">
      <?php echo $contentData[7]['content'] ?>
      <div class="restaurant-rating">
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
      </div>
      <?php echo $contentData[8]['content'] ?>
      <div class="restaurant-contact">
        <div class="restaurant-address">
          <p><?php echo htmlspecialchars($restaurantDetails->getLocation())?></p>
        </div>
        <div class="restaurant-phone">
          <p><?php echo htmlspecialchars($restaurantDetails->getStartDate())?></p>
        </div>
        <div class="restaurant-email">
          <p><?php echo htmlspecialchars($restaurantDetails->getEndDate())?></p> 
        </div>
        <?php echo $restaurantDetails->getPrice()?>
      </div>
    </div>
  </div>
</div>



<div class="container-table mt-5">
  <div class="table-wrapper">
    <table class="table table-dark">
      <thead>
        <tr>
          <th scope="col">TimeSlots</th>
          <th scope="col">Ticket ID</th>
          <th scope="col">Date</th>
          <th scope="col">Time</th>
          <th scope="col">Quantity</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($timeslots as $index => $ticket): ?>
          <tr>
              <th scope="row"><?php echo $index + 1; ?></th>
              <td><?php echo htmlspecialchars($ticket->getTicketId()); ?></td>
              <td><?php echo htmlspecialchars($ticket->getTicketDate()); ?></td>
              <td><?php echo htmlspecialchars($ticket->getTicketTime()); ?></td>
              <td><?php echo htmlspecialchars($ticket->getQuantity()); ?></td>
              <td>
                <button class="btn btn-primary btn-block btn-reserve reserve-btn" 
                data-ticket-id="<?= htmlspecialchars($ticket->getTicketId()) ?>"
                data-event-id="<?= htmlspecialchars($ticket->getEventId()) ?>"
                data-endtime="<?= htmlspecialchars(date('H:i', strtotime($ticket->getTicketTime() . '  +8 hours'))) ?>"
                data-price="<?= htmlspecialchars($restaurantDetails->getPrice()) ?>"
                data-date="<?= htmlspecialchars($ticket->getTicketDate()) ?>"
                data-time="<?= htmlspecialchars($ticket->getTicketTime()) ?>"
                data-location="<?= htmlspecialchars($restaurantDetails->getLocation()) ?>"
                data-restaurant-name="<?= htmlspecialchars($restaurantDetails->getName()) ?>"
                data-special-remarks="">Reserve</button>
              </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<h2 class="gallery">Gallery</h2>
<div class="container mt-5">
  <div class="row">
    <div class="col-md-4 mb-4">
      <img src="/img/uploadshaarlem.jpg" alt="Image 1" class="img-fluid">
    </div>
    <div class="col-md-4 mb-4">
      <img src="/img/uploadshaarlem.jpg" alt="Image 2" class="img-fluid">
    </div>
    <div class="col-md-4 mb-4">
      <img src="/img/uploadshaarlem.jpg" alt="Image 3" class="img-fluid">
    </div>
  </div>
</div>

<h2 class="location-google-maps">Location</h2>

<div class="picture-location">
  <img src="/img/uploadshaarlem.jpg" alt="Location Picture" class="img-location">
</div>

<?php require_once __DIR__ . '/../../views/reservation-form/popup-reservation-restaurant.php' ?>


<script src="/js/add-reservation.js"></script>




<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.9/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<?php include __DIR__ . '/../general_views/footer.php'; ?>

</body>
</html>
