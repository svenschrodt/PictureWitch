<?php declare(strict_types = 1);


// Enabling full error reporting for dev environment
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


require_once 'Bootstrap.php';

// echo 'P7Graph - FOOOOOOOOOOOOOOO!' . PHP_EOL;
$cfg = new \P7Graph\Config();
$drw = new \P7Graph\Drawing($cfg);


$maxX = $cfg->maxWidth - 1;
$maxY = $cfg->maxHeight - 1;
$halfX = round($maxX/2,0);
$halfY = round($maxY/2,0);
$qw = 0;
for($x=-5;$x<5;$x+=0.01) {
    
    
    $y1 = $x ;
    $y2 = $x*$x ;
    $y3 = $x*$x*$x ;
    $scaleX = (int) (100 * $x + $halfX);
    
    $scaleY1 = (int) ($halfY -(100 * $y1));
    $scaleY2 = (int) ($halfY -(100 * $y2));
    $scaleY3 = (int) ($halfY -(100 * $y3));
//     echo "[$scaleX - $scaleY]";
//     echo "[$x - $y]";
//        echo PHP_EOL;
       
$drw->setPixel($scaleX, $scaleY1, 'black');
$drw->setPixel($scaleX, $scaleY2, 'blue');
$drw->setPixel($scaleX, $scaleY3, 'green');
}

// echo "$maxX, $maxY\n";
 $drw->show();
