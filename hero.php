<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <?php
    $jsonFile = 'assets/data/heroConfig.json';
    $heroItems = json_decode(file_get_contents($jsonFile), true);
    ?>

    <!-- Indicators -->
    <div class="carousel-indicators">
        <?php foreach ($heroItems as $index => $item) : ?>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index ?>" 
                class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" 
                aria-label="Slide <?= $index + 1 ?>"></button>
        <?php endforeach; ?>
    </div>

    <!-- Carousel Inner -->
    <div class="carousel-inner">
        <?php foreach ($heroItems as $index => $item) : ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <?php if ($item['clickable']) : ?>
                    <a href="<?= htmlspecialchars($item['href']) ?>">
                        <img src="<?= htmlspecialchars($item['image']) ?>" class="d-block w-100" alt="Hero Image <?= $index + 1 ?>">
                    </a>
                <?php else : ?>
                    <img src="<?= htmlspecialchars($item['image']) ?>" class="d-block w-100" alt="Hero Image <?= $index + 1 ?>">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
