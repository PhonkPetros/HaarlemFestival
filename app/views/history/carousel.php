<?php
$carouselItemsHtml = '';
foreach ($carouselItems['carouselItems'] as $carouselIndex => $carouselItem) {
    $activeClass = $carouselIndex === 0 ? 'active' : '';
    $imageSrc = htmlspecialchars($carouselItem['image']);
    $altText = htmlspecialchars($carouselItem['label']);
    $carouselItemsHtml .= "<div class='carousel-item {$activeClass}'>";
    $carouselItemsHtml .= "<img src='/img/uploads/{$imageSrc}' alt='{$altText}' class='d-block' style='width: 70%; height: 600px; object-fit: cover; display: block; margin: auto;'>";
    $carouselItemsHtml .= "<div class='carousel-caption d-none d-md-block' style='position: absolute; bottom: 0; left: 0; right: 0; background-color: rgba(0, 0, 0, 0.5); padding: 10px;'><h5>{$altText}</h5></div>";
    $carouselItemsHtml .= "</div>";
}
$controlsHtml = count($carouselItems['carouselItems']) > 1 ? "<a class='carousel-control-prev' href='#locationsCarousel' role='button' data-slide='prev'><span class='carousel-control-prev-icon' aria-hidden='true'></span><span class='sr-only'>Previous</span></a><a class='carousel-control-next' href='#locationsCarousel' role='button' data-slide='next'><span class='carousel-control-next-icon' aria-hidden='true'></span><span class='sr-only'>Next</span></a>" : '';
?>
<div class='bg-dark text-white p-3'>
    <div id='locationsCarousel' class='carousel slide' data-ride='carousel'>
        <div class='carousel-inner'>
            <?= $carouselItemsHtml ?>
        </div>
        <?= $controlsHtml ?>
    </div>
</div>