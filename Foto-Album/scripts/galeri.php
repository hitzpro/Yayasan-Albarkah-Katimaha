<?php
$dir = '../images/';
$category = isset($_GET['category']) ? $_GET['category'] : 'TK';
$images_dir = $dir . $category . '/';
$images = glob($images_dir . '*.{jpg,jpeg,png,gif,JPG,PNG,JPEG}', GLOB_BRACE);

if (!$images) {
    echo json_encode(["error" => "No images found in the specified directory."]);
    exit;
}

// Ambil parameter offset dan limit
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;

// Acak dan potong array gambar
$images = array_map('basename', $images);
shuffle($images);
$sliced_images = array_slice($images, $offset, $limit);

echo json_encode($sliced_images);  // Kembalikan gambar dalam format JSON
?>
