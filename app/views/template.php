<div class="container-fluid-type bg-dark">
  <?php foreach ($contentData as $sectionData): ?>
    <?php
    $sectionType = $sectionData['type'] ?? '';
    $style = '';
    if ($sectionType === 'Banner' && !empty ($sectionData['image']) && $sectionData['image'] !== 'default.png') {
      $imagePath = '/img/uploads/' . $sectionData['image'];
      $style = "background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('$imagePath') no-repeat center/cover;";
    }
    ?>

    <div class="section-type <?= htmlspecialchars($sectionType) ?>-type" style="<?= $style ?>">
      <?php if ($sectionType === 'ImageText'): ?>
        <div class="image-text-type">
          <div class="text-block-type">
            <?= $sectionData['content'] ?>
          </div>
          <div class="image-block-type">
            <img src='/img/uploads/<?= $sectionData['image'] ?>' alt='Section Image'>
          </div>
        </div>
      <?php elseif ($sectionType === 'Image'): ?>
        <div class="image-type">
          <img src='/img/uploads/<?= $sectionData['image'] ?>' alt='Section Image' class="img-fluid">
        </div>
      <?php elseif ($sectionType === 'Body'): ?>
        <div style="max-width: 900px; margin: auto; text-align: center;">
          <?= $sectionData['content'] ?>
        </div>
      <?php elseif ($sectionType === 'Title'): ?>
        <div style="background-color: #f8f9fa; color: #212529; display: flex; justify-content: center; align-items: center; height: 80px; ">
          <?= $sectionData['content'] ?>
        </div>
      <?php else: ?>
        <div class="<?= htmlspecialchars($sectionType) ?>-type">
          <?= $sectionData['content'] ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>

<?php include __DIR__ . '/general_views/footer.php'; ?>