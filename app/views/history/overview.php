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
    <?php include __DIR__ . '/../history/page-content.php'; ?>

    <?php include __DIR__ . '/../history/tickettimtable.php'; ?>
  </div>

  <?php include __DIR__ . '/../general_views/footer.php'; ?>