<?php
// Ensure mapConfig.json is correctly read
$mapConfigPath = $baseFilePath . "assets/data/mapConfig.json";
$mapData = file_exists($mapConfigPath) ? json_decode(file_get_contents($mapConfigPath), true) : ["embed_html" => ""];

$mapEmbed = $mapData["embed_html"] ?? "";
?>

<div class="container my-4 bg-light">
    <h3 class="text-center">Where to Find Us</h3>
    <?php if (!empty($mapEmbed)): ?>
        <div class="ratio ratio-16x9"><?= $mapEmbed ?></div>
    <?php else: ?>
        <p class="text-center">No map available. Please set the location in the admin panel.</p>
    <?php endif; ?>
</div>
