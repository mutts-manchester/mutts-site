<?php
// Read in image and output it as a square with sides $size px long
// E.g. ./image.php?img=img/myimage.jpg&size=200

if (!array_key_exists('img', $_GET) || !array_key_exists('size', $_GET) || !is_numeric($_GET['size']))
{
    header('HTTP/1.0 400 Bad Request');
    die ('Bad request (wrong parameters)');
}


$file = $_GET['img'];
$size = $_GET['size'];

if (!file_exists($file))
{
    header('HTTP/1.0 404 Not Found');
    die ('Requested file does not exist');
}

$explodedFile = explode('.', $file);
$fileExtension = strtolower($explodedFile[count($explodedFile) - 1]);

$image = null;

if ($fileExtension == 'png')
    $image = imagecreatefrompng($file);
else if ($fileExtension == 'jpg' || $fileExtension = 'jpeg')
    $image = imagecreatefromjpeg($file);
else 
{
    header('HTTP/1.0 500 Internal Server Error');
    die ('Unsupported extension ' . $fileExtension);
}

// First crop into a square
$x = imagesx($image);
$y = imagesy($image);

if ($x > $y)
    $image = imagecrop($image, ['x' => ($x - $y) / 2, 'y' => 0, 'width' => $y, 'height' => $y]);
else
    $image = imagecrop($image, ['x' => 0, 'y' => ($y - $x) / 2, 'width' => $x, 'height' => $x]);

// Now scale image to given size
$image = imagescale($image, $size);

header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>