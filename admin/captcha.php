<?php
session_start(); // Start Session
// Set the Http header content type
header('Content-type: image/jpeg');

// Show lines in captcha
$showLine = true;
// Captcha Height
$winHeight = 40;
// Captcha Width
$winWidth = 200;
// Get Captcha text from session variable
$Text = $_SESSION['captcha_text'];

//background image
$image = imagecreate($winWidth, $winHeight)
or die("<b>" . __FILE__ . "</b><br />" . __LINE__ . " : 
            	" ."Cannot Initialize new GD image stream");
// Set Background color
$bg = imagecolorallocate($image, 0, 102, 204);
// Fill color
imagefill($image, 10, 10, $bg);
// Set Text color
$char_color = imagecolorallocate($image, 255, 255, 255);

// Set Font
$font = '../fonts/captcha_font.ttf';
// Set Font Size
$font_size = 24;
////////////////////////////////////
//Image text
imagettftext($image, $font_size, 0,
    15, 30, $char_color, $font, $Text);

////////////////////////////////////
// lines
$char_color = imagecolorallocate($image,0,0,0);
if ($showLine)
{
    // Draw lines
    for ($i=0; $i<$winWidth; $i++ )
    {
        if ($i%10 == 0)
        {
            imageline ( $image, $i, 0,
                $i+10, 50, $char_color );
        }
    }
}

////////////////////////////////////
// Convert Image to JPEG
imagejpeg($image);
?>