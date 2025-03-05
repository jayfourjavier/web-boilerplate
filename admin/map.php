<?php
include 'header.php'; // Include the admin header

$mapConfigFile = "../assets/data/mapConfig.json";

// Load existing data
$mapData = file_exists($mapConfigFile) ? json_decode(file_get_contents($mapConfigFile), true) : ["embed_html" => ""];

// Save new embed HTML when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mapData["embed_html"] = $_POST['map_embed'];
    file_put_contents($mapConfigFile, json_encode($mapData, JSON_PRETTY_PRINT));
}

$mapEmbed = $mapData["embed_html"];
?>

<div class="container-lg">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-3 text-center">Set Google Map Embed</h2>
            
            <form method="POST" class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label fw-bold m-0">Google Maps Embed Code:</label>
                    <button type="button" class="btn btn-sm btn-success text-white" data-bs-toggle="modal" data-bs-target="#howToEmbedModal">
                        How to get Google Maps Embed Code?
                    </button>
                </div>
                <textarea name="map_embed" class="form-control mt-2" rows="5" placeholder="Paste the full iframe HTML here"><?= htmlspecialchars($mapEmbed) ?></textarea>
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary">Save Map</button>
                </div>
            </form>

            <h3 class="mt-4 text-center">Map Preview</h3>
            <div class="d-flex justify-content-center">
                <?php if ($mapEmbed): ?>
                    <div class="ratio ratio-16x9 w-100"><?= $mapEmbed ?></div>
                <?php else: ?>
                    <p class="text-muted text-center">No map set. Paste the embed code above.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- How to Get Google Maps Embed Code Modal -->
<div class="modal fade" id="howToEmbedModal" tabindex="-1" aria-labelledby="howToEmbedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="howToEmbedModalLabel">How to Get Google Maps Embed Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ratio ratio-16x9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/EoniAikTmr8?si=3qrMppajHSuMVEx3" 
                        title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; // Include the admin footer ?>
