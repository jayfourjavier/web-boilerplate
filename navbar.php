<?php

// Load navigation menu from JSON
$navConfigPath = $baseFilePath . "assets/data/navconfig.json";
$navConfig = file_exists($navConfigPath) ? json_decode(file_get_contents($navConfigPath), true) : [];
$menuItems = $navConfig['menu'] ?? [];
?>

<!-- Sticky-top Navbar -->
<nav class="navbar navbar-expand-lg sticky-top px-2 bg-light text-center" id="mainNavbar">
    <div class="d-flex align-items-center w-100">
        <button class="btn btn-outline-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
            <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand ms-2" href="<?= $baseUrl ?>"><?= htmlspecialchars($businessName) ?></a>
    </div>
</nav>

<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start" id="offcanvasNavbar">
    <div class="offcanvas-header bg-success">
        <h5 class="offcanvas-title fs-4 fw-bold text-white">Menu</h5> <!-- Title made bold and larger -->
        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button> <!-- Dark close button -->
    </div>
    <div class="offcanvas-body bg-light">
        <ul class="nav flex-column">
            <?php foreach ($menuItems as $item): 
                $fullPath = $baseUrl . ltrim($item['href'], "/");
            ?>
                <li class="nav-item">
                    <a class="nav-link py-2 px-3 rounded-3 mb-2 shadow-sm bg-primary text-white" href="<?= $fullPath ?>" onclick="closeOffcanvas()"> <!-- Dark background and white text -->
                        <i class="fa <?= htmlspecialchars($item['icon']) ?> me-2"></i> <!-- Font Awesome icon with margin-right -->
                        <?= htmlspecialchars($item['name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
// Close Offcanvas on Menu Click
function closeOffcanvas() {
    var offcanvas = document.getElementById('offcanvasNavbar');
    var bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
    if (bsOffcanvas) bsOffcanvas.hide();
}
</script>

<!-- Custom Styles -->
<style>
    .nav-link:hover {
        background-color: #343a40; /* Darker background on hover */
        color: #fff; /* Keep text white on hover */
    }
</style>
