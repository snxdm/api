<?php
$type = $_GET['type'] ?? null;
$return = $_GET['return'] ?? null;
$validTypes = ['wallpaper', 'anime', 'avatar'];
$validReturns = ['png', 'json'];
if (!in_array($type, $validTypes) || !in_array($return, $validReturns)) {
    die('Invalid parameters.');
}
$url = "https://storage.ify.pages.dev/api/image/$type/$type.json";
$data = file_get_contents($url);
$images = json_decode($data);
if (empty($images)) {
    die('Image data not found.');
}
$randomImage = $images[array_rand($images)];
$imageUrl = "https://storage.ify.pages.dev/api/image/$type/$randomImage";
if ($return === 'png') {
    header('Content-Type: image/png');
    readfile($imageUrl);
} else {
    $response = ['type' => $type, 'url' => $imageUrl];
    header('Content-Type: application/json');
    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
?>
