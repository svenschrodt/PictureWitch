<?php declare(strict_types = 1);


// Enabling full error reporting for dev environment
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


require_once 'Bootstrap.php';

$inst = new PictureWitch\Meta\Exif();



$file = 'src/public/bin/2020-02-24/20200224_172912.jpg';
$exif = $inst->readExifDataFromFile($file);
// echo date('Y-m-d H:i:s', $exif['FileDateTime']);

$gps = $inst->getCoordinatesFromExif($exif);

$osmUrl = "https://www.openstreetmap.org/#map=18/{$gps->lat}/{$gps->long}";

echo $osmUrl;