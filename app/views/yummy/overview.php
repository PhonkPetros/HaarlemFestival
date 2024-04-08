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
    <img src="/img/<?php echo $overviewContent[2]['image']?>" class="my-image" style="width: 50%; float: left;">

    <img src="/img/<?php echo $overviewContent[3]['image']?>" class="my-image-right" style="width: 50%; float: right;">
    
    <?php echo $overviewContent[0]['content']?>
</div>


<?php echo $overviewContent[1]['content']?>



<div class="container mt-5">
    <div class="row">
        <?php foreach ($restaurants as $restaurant): ?>
            <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                <a href="/restaurant/details/<?= htmlspecialchars($restaurant->getId()) ?>" class="text-decoration-none">
                    <div class="card">
                    <img src="/img/<?= htmlspecialchars($restaurant->getPicture()) ?>" class="card-img-top img-fluid img-fixed-height" alt="<?= htmlspecialchars($restaurant->getLocation()) ?>">
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
