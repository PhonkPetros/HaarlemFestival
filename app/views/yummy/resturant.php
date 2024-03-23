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
  <div class="div-2">
  </div>
</div>

<section class="cuisine-container">
</section>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-3 mb-4 img-container">
    <div class="white-background">
    </div>
  </div>

  <div class="col-md-3 mb-4 img-container">
    <div class="white-background">
    </div>
  </div>

  <div class="col-md-3 mb-4 img-container">
    <div class="white-background">
    </div>
  </div>
  <div class="col-md-3 mb-4 img-container">
    <div class="white-background">
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

<div class="container mt-5">
  <div class="row">
    <div class="col-md-4 mb-4">
    </div>
    <div class="col-md-4 mb-4">
    </div>
    <div class="col-md-4 mb-4">
    </div>
  </div>
</div>


<div class="location-google-maps white-text">
</div>



<div class="picture-location">
</div>


<?php  echo var_dump($contentData);
?>

<?php include __DIR__ . '/../general_views/footer.php'; ?>

<style>
 
</style>

</body>
</html>
