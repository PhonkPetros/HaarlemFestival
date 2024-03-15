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
  <img src="/img/<?= htmlspecialchars($restaurantDetails->getPicture()) ?>"class="img"/>
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
      <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/e6b9d2fa0bd8720d689b407eb7393c75ec19d1f5ac77d8eed0b7883c2b222a7e?apiKey=3023167e7a8a4e649532aa6db2acfe06" alt="Caviar dish" class="img-fluid">
      <h3 class="mt-2">Caviar</h3>
      <p>The luxurious caviar comes from the Caspian sea, having a rich flavor from the seas.</p>
    </div>

    <div class="col-md-3 mb-4">
      <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/382dbd9e0152b826ee02de8c0c458b76e93b38cf8d23090edb2dfca2295114fb?apiKey=3023167e7a8a4e649532aa6db2acfe06" alt="Le dîner dish" class="img-fluid">
      <h3 class="mt-2">Le dîner</h3>
      <p>The expensive Kinmemai rice comes from the Japanese fields, hand picked by the finest hands, stored in the finest basement.</p>
    </div>

    <div class="col-md-3 mb-4">
      <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/5b74d21539d7f45ef0435d9e99a97ca7c77f408ec7373a6387c8806243772316?apiKey=3023167e7a8a4e649532aa6db2acfe06" alt="Le déjeuner dish" class="img-fluid">
      <h3 class="mt-2">Le déjeuner</h3>
      <p>The finest caramel cheesecake made specifically from the rarest breed of goats with a pinch of French grapes.</p>
    </div>

    <div class="col-md-3 mb-4">
      <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/7e5ba470343a9de87d966cb07eeadb814fcea36824f470a9ffc29749e4c53177?apiKey=3023167e7a8a4e649532aa6db2acfe06" alt="Le repas dish" class="img-fluid">
      <h3 class="mt-2">Le repas</h3>
      <p>The French curry made from special herbs has a special taste from the rarest herbs.</p>
    </div>
  </div>
</div>

<div class="akm-49">
  <div class="info">
    <div class="picture">
      <img src="/img/uploadshaarlem.jpg" alt="Restaurant Picture" class="img-fluid">
    </div>
    <div class="content">
      <h1>Traditional French cuisine</h1>
      <div class="rating">
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
      </div>
      <p>Made with tremendous amount of love and skill, the meals made by Chef Jfouza are renown in Haarlem for their unique taste from simple spaghetti meatballs to the famous world renown ratatouille.</p>
      <div class="contact">
        <p> 💯<?= htmlspecialchars($restaurantDetails->getStartDate())?></p>
        <p> ⏱<?= htmlspecialchars($restaurantDetails->getEndDate())?></p>
        <p>📍 <?= htmlspecialchars($restaurantDetails->getLocation())?></p>
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

<?php include __DIR__ . '/../general_views/footer.php'; ?>

</body>
</html>
