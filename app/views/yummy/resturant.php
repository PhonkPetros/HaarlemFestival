<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/resturant.css"  rel="stylesheet" !important>
    <link href="/css/yum.css"  rel="stylesheet" !important>
</head>
<body>
<div class="div">
  <img src="/img/<?= htmlspecialchars($restaurantDetails->getPicture()) ?>"class="img"/>
  <div class="div-2">
    <?php echo $contentData[2]['content']; ?>
  </div>
</div>

<section class="cuisine-container">
  <img src="/img/uploads/<?php echo $contentData[26]['image']; ?>" alt="French cuisine" class="cuisine-image" />
  <?php echo $contentData[3]['content']; ?>
</section>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-3 mb-4 img-container">
    <img src="/img/uploads/<?php echo $contentData[22]['image']; ?>" alt="Caviar dish" class="img-fluid">
    <div class="white-background">
      <?php echo $contentData[4]['content']; ?>
    </div>
  </div>

  <div class="col-md-3 mb-4 img-container">
    <img src="/img/uploads/<?php echo $contentData[23]['image']; ?>" alt="Le dîner dish" class="img-fluid">
    <div class="white-background">
      <?php echo $contentData[5]['content']; ?>
    </div>
  </div>

  <div class="col-md-3 mb-4 img-container">
    <img src="/img/uploads/<?php echo $contentData[24]['image']; ?>" alt="Le déjeuner dish" class="img-fluid">
    <div class="white-background">
      <?php echo $contentData[6]['content']; ?>
    </div>
  </div>
  <div class="col-md-3 mb-4 img-container">
    <img src="/img/uploads/<?php echo $contentData[25]['image']; ?>" alt="Le déjeuner dish" class="img-fluid">
    <div class="white-background">
      <?php echo $contentData[7]['content']; ?>
    </div>
  </div>
  </div>
</div>





<div class="container-table mt-5">
  <div class="table-wrapper">
    <table class="table table-dark">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td>Larry</td>
          <td>the Bird</td>
          <td>@twitter</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php echo $contentData[9]['content']; ?>
<div class="container mt-5">
  <div class="row">
    <div class="col-md-4 mb-4">
      <img src="/img/uploads/<?php echo $contentData[28]['image']; ?>" alt="Image 1" class="img-fluid custom-img">
    </div>
    <div class="col-md-4 mb-4">
      <img src="/img/uploads/<?php echo $contentData[29]['image']; ?>" alt="Image 2" class="img-fluid custom-img">
    </div>
    <div class="col-md-4 mb-4">
      <img src="/img/uploads/<?php echo $contentData[30]['image']; ?>" alt="Image 3" class="img-fluid custom-img">
    </div>
  </div>
</div>


<div class="location-google-maps white-text">
    <?php echo $contentData[10]['content']; ?>
</div>



<div class="picture-location">
  <img src="/img/uploads/<?php echo $contentData[22]['image']; ?>" alt="Location Picture" class="img-location">
</div>

<?php include __DIR__ . '/../general_views/footer.php'; ?>

<style>
 
</style>

</body>
</html>
