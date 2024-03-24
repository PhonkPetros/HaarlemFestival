<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/resturant.css">
</head>
<body>
<div class="div">
<?php
if ($restaurantDetails !== null) {
  $picture = $restaurantDetails->getPicture();
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
    <?php echo $contentData[0]['content']?>
    <?php echo $contentData[1]['content']?>
  </div>
</div>

<section class="cuisine-container">
  <img src="/img/<?php echo $contentData[2]['image']?>" alt="French cuisine" class="cuisine-image" />
  <?php echo $contentData[2]['content']?>
</section>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-3 mb-4">
      <img src="/img/<?php echo $contentData[3]['image']?>" alt="Caviar dish" class="img-fluid">
      <?php echo $contentData[3]['content']?>
    </div>

    <div class="col-md-3 mb-4">
      <img src="/img/<?php echo $contentData[4]['image']?>" alt="Le dîner dish" class="img-fluid">
      <?php echo $contentData[4]['content']?>
    </div>

    <div class="col-md-3 mb-4">
      <img src="/img/<?php echo $contentData[5]['image']?>" alt="Le déjeuner dish" class="img-fluid">
      <?php echo $contentData[5]['content']?>
    </div>

    <div class="col-md-3 mb-4">
      <img src="/img/<?php echo $contentData[6]['image']?>" alt="Le repas dish" class="img-fluid">
      <?php echo $contentData[6]['content']?>
    </div>
  </div>
</div>

<div class="akm-49">
  <div class="info">
    <div class="picture">
      <img src="/img/<?php echo $contentData[7]['image']?>" alt="Restaurant Picture" class="img-fluid">
    </div>
    <div class="content">
    <?php echo $contentData[7]['content']?>
      <div class="rating">
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
      </div>
      <?php echo $contentData[8]['content']?>
      <div class="contact">
</div>

      <button class="book-table">BOOK A TABLE</button>
    </div>
  </div>
</div>


<div class="container-table mt-5">
  <div class="table-wrapper">
    <table class="table table-dark">
      <thead>
        <tr>
          <th scope="col">TimeSlots</th>
          <th scope="col">Date</th>
          <th scope="col">Time</th>
          <th scope="col">Quantity</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($timeslots as $index => $ticket): ?>
          <tr>
            <th scope="row"><?php echo $index + 1; ?></th>
            <td><?php echo htmlspecialchars($ticket->getTicketDate()); ?></td>
            <td><?php echo htmlspecialchars($ticket->getTicketTime()); ?></td>
            <td><?php echo htmlspecialchars($ticket->getQuantity()); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>


<?php echo $contentData[9]['content']?>
<div class="container mt-5">
  <div class="row">
    <div class="col-md-4 mb-4">
      <img src="/img/<?php echo $contentData[9]['image']?>" alt="Image 1" class="img-fluid">
    </div>
    <div class="col-md-4 mb-4">
      <img src="/img/<?php echo $contentData[9]['image']?>" alt="Image 2" class="img-fluid">
    </div>
    <div class="col-md-4 mb-4">
      <img src="/img/<?php echo $contentData[9]['image']?>" alt="Image 3" class="img-fluid">
    </div>
  </div>
</div>

<?php echo $contentData[10]['content']?>
<div class="picture-location">
  <img src="/img/<?php echo $contentData[10]['image']?>" alt="Location Picture" class="img-location">
</div>

<?php include __DIR__ . '/../general_views/footer.php'; ?>

</body>
</html>