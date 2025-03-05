<?php
$jsonFile = __DIR__ . "/../../assets/data/heroConfig.json"; // Correct path

// Ensure the directory exists
if (!file_exists(dirname($jsonFile))) {
    mkdir(dirname($jsonFile), 0777, true);
}

// Ensure the JSON file exists
if (!file_exists($jsonFile)) {
    file_put_contents($jsonFile, "[]");
}

// Load existing banners
$heroImages = json_decode(file_get_contents($jsonFile), true) ?? [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES["bannerImage"]) && $_FILES["bannerImage"]["error"] === 0) {
        $uploadDir = __DIR__ . "/../../assets/images/banners/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES["bannerImage"]["name"]);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["bannerImage"]["tmp_name"], $targetFile)) {
            $newBanner = [
                "image" => "assets/images/banners/" . $fileName,
                "link" => $_POST["link"] ?? "#"
            ];
            $heroImages[] = $newBanner;
            file_put_contents($jsonFile, json_encode($heroImages, JSON_PRETTY_PRINT));

            echo json_encode(["success" => true]);
            exit;
        } else {
            echo json_encode(["success" => false, "error" => "File upload failed"]);
            exit;
        }
    } else {
        echo json_encode(["success" => false, "error" => "No image uploaded"]);
        exit;
    }
}
?>
