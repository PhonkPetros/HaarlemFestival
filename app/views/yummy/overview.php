<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Yummy Haarlem</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="/css/yummy-overview.css">
</head>
<body>
<div class="wrapper-pictures">
    <img src="/img/5315657.jpg" class="my-image" style="width: 50%; float: left;">
    
    <img src="/img/AdobeStock_238205293.jpg" class="my-image-right" style="width: 50%; float: right;">
    
    <h2>Yummy Haarlem</h2>
    <p class="paragraph-inside-image">A group of restaurants participate in the event, from 27 to 31, when you go to one of the detailed pages of the restaurant you can select a timeslot from the calendar from the following restaurants, if the spot and hour are available you can select the amount of people and reserve the spot after you pay for the ticket in my program.</p>
</div>





<div class="white-background">
<section class="my-5">
  <div class="container">
    <h2 class="how-does-it-work">How does the yummy concept work?</h2>
    <p class="resturant-description">A group of restaurants participate in the event, from 27 to 31, when you go to one of the detailed pages of the restaurant you can select a timeslot from the calendar from the following restaurants, if the spot and hour are available you can select the amount of people and reserve the spot after you pay for the ticket in my program.</p>
  </div>
</section>

<section class="yummy-heading">
    <div class="container-50-off">
        <h2>50% for kids below the age of 12</h2>
    </div>
</section>
</div>

<div class="container mt-5">
    <div class="row">
        <?php foreach ($restaurants as $restaurant): ?>
            <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                <a href="/restaurant/details/<?= htmlspecialchars($restaurant->getId()) ?>" class="text-decoration-none">
                    <div class="card">
                    <img src="<?= htmlspecialchars($restaurant->getPicture()) ?>" class="card-img-top img-fluid img-fixed-height" alt="<?= htmlspecialchars($restaurant->getLocation()) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($restaurant->getName()) ?></h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Description: <?= htmlspecialchars($restaurant->getDescription()) ?></li>
                                <li class="list-group-item">Location: <?= htmlspecialchars($restaurant->getLocation()) ?></li>
                                <li class="list-group-item">Price: <?= htmlspecialchars($restaurant->getPrice()) ?></li>
                                <li class="list-group-item">Seats: <?= htmlspecialchars($restaurant->getSeats()) ?></li>
                            </ul>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .img-fixed-height {
  max-width: 100% !important;
  height: 200px !important;
  object-fit: cover !important;
}

</style>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


<?php include __DIR__ . '/../general_views/footer.php'; ?>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.9/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
