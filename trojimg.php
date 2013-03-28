<?

$s = explode("-", $_GET['trojuhelnik']);
if(!is_numeric($s[0]) or !is_numeric($s[1]) or !is_numeric($s[2])){die();}

$triangle = array($s[0], $s[1], $s[2]);

$c = $triangle[2]; // base
$b = $triangle[1]; // sides
$a = $triangle[0];

// calculate angle, cosine rule
$alpha = acos((pow($b,2) + pow($c,2) - pow($a,2)) / (2 * $b * $c)); 

// pythag to calc height and y distance
$height = abs(sin($alpha)) * $b;
$width = abs(cos($alpha)) * $b;

$x = 20; // start point
$y = $height+20;

$points = array(
    $x, $y,                // start
    $x+$c, $y,                // base
    $x+$width, $y-$height     // apex
    );

// draw

$image = imagecreatetruecolor($c+40, $height+40);
imageSaveAlpha($image, true);
ImageAlphaBlending($image, false);

$transparentColor = imagecolorallocatealpha($image, 200, 200, 200, 127);
imagefill($image, 0, 0, $transparentColor);

$blue =  imagecolorallocatealpha( $image, 21, 44, 158, 0 );

imagefilledpolygon($image, $points, 3, $blue);
header('Content-type: image/png');
imagepng($image);
imagedestroy($image); 

?>