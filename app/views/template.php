<div class="bg-dark">
<div class="container my-5 ">
  <?php foreach ($contentData as $sectionData): ?>
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">
        <div class=' text-white text-center p-3'>
          <?= ($sectionData['content']) ?>
          <?php if (!empty($sectionData['image']) && $sectionData['image'] !== 'default.png'): ?>
            <img src='/img/uploads/<?= htmlspecialchars($sectionData['image']); ?>' alt='Section Image' class='img-fluid' style="max-height: 400px;">
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
</div>

<?php include __DIR__ . '/general_views/footer.php'; ?>
