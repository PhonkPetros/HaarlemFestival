<?php if (!empty($carouselItems['carouselItems'])): ?>
    <div class="mb-3">
        <label class="form-label">Carousel Items</label>
        <div class="row g-3">
            <?php foreach ($carouselItems['carouselItems'] as $index => $carouselItem): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100">
                        <img src="/img/uploads/<?php echo htmlspecialchars($carouselItem['image']); ?>" class="card-img-top"
                            alt="<?php echo htmlspecialchars($carouselItem['label']); ?>"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <div class="mb-2">
                                <input type="hidden" name="carouselId[<?php echo $index; ?>]"
                                    value="<?php echo isset($carouselItem['carousel_id']) ? htmlspecialchars($carouselItem['carousel_id']) : 'ID not set'; ?>"
                                    readonly>
                            </div>
                            <input type="file" name="carouselImage[<?php echo $index; ?>]" class="form-control mb-2">
                            <input type="text" name="carouselLabel[<?php echo $index; ?>]" class="form-control mb-2"
                                value="<?php echo htmlspecialchars($carouselItem['label']); ?>">
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>