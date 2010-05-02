<?php

/**
 * Current script generate image with 
 * numbers that used as CAPTCHA
 * @author Ilya G. Drobenya
 */

header("Content-type: image/png");

define('IMAGE_WIDTH', 200);
define('IMAGE_HEIGHT', 50);
define('PADDING', 19);
$lines_count = 9;

// create random text
$text = (string)rand(1000000, 9999999);
@session_start();
$_SESSION['captcha'] = $text; 

// create image
$img = imagecreatetruecolor(IMAGE_WIDTH, IMAGE_HEIGHT);
//imagefill($img, 0, 0, $background_color);

$bg_r = rand(0, 55);
$bg_g = rand(0, 55);
$bg_b = rand(0, 55);
for ($i = 0; $i < IMAGE_WIDTH; ++$i) {
    $background_color = imagecolorallocate($img, $bg_r, 
        $bg_g, $bg_b);
    imageline($img, $i, 0, $i, IMAGE_HEIGHT, $background_color);
    $bg_r = ($bg_r + rand(0, 5)) % 190;
    $bg_g = ($bg_g + rand(0, 5)) % 190;
    $bg_b = ($bg_b + rand(0, 5)) % 190;
}

    

// draw text
$symbol_padding = IMAGE_WIDTH / strlen($text);
$start_x = $symbol_padding / 2;
$fonts = array(
    'images/fonts/1.ttf',
    'images/fonts/2.ttf',
    'images/fonts/3.ttf',
    'images/fonts/4.ttf',
    'images/fonts/5.ttf' 
);
 
for ($i = 0; $i < strlen($text); ++$i) {
    $text_color = imagecolorallocate($img, 180 + rand(0, 40), 
        180 + rand(0, 40), 180 + rand(0, 40));
        
    imagettftext($img, 23, rand(-45, 45), $start_x,
         rand(PADDING, IMAGE_HEIGHT - PADDING),  
         $text_color, $fonts[rand(0, count(fonts) - 1)], $text[ $i ]);
    
    $start_x += rand($symbol_padding / 2, $symbol_padding);
}

// generate random lines
for ($i = 0; $i < $lines_count; ++$i) {
    $x1 = rand(0, IMAGE_WIDTH);
    $y1 = rand(0, IMAGE_HEIGHT);
    $x2 = rand(0, IMAGE_WIDTH);
    $y2 = rand(0, IMAGE_HEIGHT);
    $line_color = imagecolorallocate($img, 100 + rand(0, 100),
        100 + rand(0, 100), 100 + rand(0, 100));
    
    imageline($img, $x1, $y1, $x2, $y2, $line_color);
}

//imagefilter($img, IMG_FILTER_PIXELATE, 10, TRUE);
imagepng($img);
imagedestroy($img);

?>