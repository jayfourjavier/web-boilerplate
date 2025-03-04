<?php
// Read JSON config
$navConfig = json_decode(file_get_contents("assets/data/navConfig.json"), true);
$brandName = $navConfig['brand'] ?? 'Default Brand';
$menuItems = $navConfig['menu'] ?? [];
$currentUrl = basename($_SERVER['PHP_SELF']);
?>

<!-- Sticky-top Navbar -->
<nav class="navbar navbar-expand-lg sticky-top px-3" id="mainNavbar">
    <button class="btn btn-outline-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
        <i class="fas fa-bars"></i>
    </button>
    <a class="navbar-brand ms-2" href="#"><?php echo $brandName; ?></a>
    <button class="btn btn-outline-dark ms-auto" id="darkModeToggle">
        <i class="fas fa-moon"></i>
    </button>
</nav>

<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start" id="offcanvasNavbar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
            <?php foreach ($menuItems as $item): 
                $activeClass = ($currentUrl === basename($item['href'])) ? 'active' : '';
            ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $activeClass; ?>" href="<?php echo $item['href']; ?>" onclick="closeOffcanvas()">
                        <i class="<?php echo $item['icon']; ?>"></i> <?php echo $item['name']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Dark Mode Toggle
    const darkModeToggle = document.getElementById("darkModeToggle");
    const body = document.body;

    // Load saved theme
    if (localStorage.getItem("darkMode") === "enabled") {
        body.classList.add("dark-mode");
        darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
    }

    darkModeToggle.addEventListener("click", function () {
        body.classList.toggle("dark-mode");
        if (body.classList.contains("dark-mode")) {
            localStorage.setItem("darkMode", "enabled");
            darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        } else {
            localStorage.setItem("darkMode", "disabled");
            darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        }
    });
});

// Close Offcanvas on Menu Click
function closeOffcanvas() {
    var offcanvas = document.getElementById('offcanvasNavbar');
    var bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
    if (bsOffcanvas) bsOffcanvas.hide();
}
</script>