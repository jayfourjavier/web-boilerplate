<?php
$mapConfigFile = "assets/data/mapConfig.json";
$mapData = file_exists($mapConfigFile) ? json_decode(file_get_contents($mapConfigFile), true) : ["embed_html" => ""];
$mapEmbed = $mapData["embed_html"];
?>

<div class="container my-4 bg-light">
    <h3 class="text-center">Where to Find Us</h3>
    <?php if ($mapEmbed): ?>
        <div class="ratio ratio-16x9"><?= $mapEmbed ?></div>
    <?php else: ?>
        <p class="text-center">No map available. Please set the location in the admin panel.</p>
    <?php endif; ?>
</div>
