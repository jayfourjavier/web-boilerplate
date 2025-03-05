<?php
// Detect environment
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    // Localhost settings
    $baseUrl = "http://localhost/boilerplate/";
    $baseFilePath = $_SERVER['DOCUMENT_ROOT'] . "/boilerplate/";
} else {
    // Production settings
    $baseUrl = "https://test.jayfourjavier.com/";
    $baseFilePath = "/home/yourusername/public_html/"; // Adjust based on hosting
}

// Business details
$businessName = "Huling Patak Water Station";
$websiteTitle = "Huling Patak";
$faviconPath = $baseUrl . "assets/images/favicon.ico";
?>
