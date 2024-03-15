<?php foreach ($contentData as $index => $sectionData): ?>
      <?php if ($index === 0): ?>
        <div class='text-white text-center py-5 header-background1'>
          <?= ($sectionData['content']) ?>
        </div>
      <?php elseif ($index === 1): ?>
        <div class='text-white text-center p-5 header-background2'>
          <?= ($sectionData['content']) ?>
        </div>
      <?php elseif ($index === 2): ?>
        <div class='bg-light text-dark text-center p-3'>
          <?= ($sectionData['content']) ?>
        </div>
      <?php elseif ($index === 3): ?>
        <div class='text-center text-white header-background3'>
          <div class='container p-3'>
            <div class='row'>
              <div class='col-md-6 d-flex align-items-center'>
                <?= ($sectionData['content']) ?>
              </div>
              <div class='col-md-6'>
                <img src='/img/uploads/<?= htmlspecialchars($sectionData['image']) ?>' alt='Tour Route Map'
                  class='img-fluid'>
              </div>
            </div>
          </div>
        </div>
      <?php elseif ($index === 4): ?>
        <div class='bg-light text-dark text-center p-3'>
          <?= ($sectionData['content']) ?>
        </div>
      <?php else: ?>
        <?php include __DIR__ . '/../history/carousel.php'; ?>
      <?php endif; ?>
    <?php endforeach; ?>