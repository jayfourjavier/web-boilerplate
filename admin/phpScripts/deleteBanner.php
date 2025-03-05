<?php
$heroConfigPath = "../../assets/data/heroConfig.json";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $filename = isset($data["filename"]) ? basename($data["filename"]) : null;

    if (!$filename) {
        echo json_encode(["success" => false, "error" => "No file specified."]);
        exit;
    }

    // Read current hero banners
    $heroImages = file_exists($heroConfigPath) ? json_decode(file_get_contents($heroConfigPath), true) : [];

    // Filter out the image being deleted
    $updatedImages = array_filter($heroImages, function ($hero) use ($filename) {
        return basename($hero["image"]) !== $filename;
    });

    // Update JSON config
    file_put_contents($heroConfigPath, json_encode(array_values($updatedImages), JSON_PRETTY_PRINT));

    // Delete file from server
    $filePath = "../../assets/images/banner/" . $filename;
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Invalid request."]);
}
?>
