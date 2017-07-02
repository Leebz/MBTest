<?php
session_start();
$width = 50;
$height = 22;
$img = imagecreatetruecolor($width, $height);
$times = 4;
//$arr1=range("a","z");
$arr2 = range(0, 9);
//$arr3=range("A","Z");
//$arr=array_merge($arr1,$arr2,$arr3);
$arr = array_merge($arr2);
$keys = array_rand($arr, $times);
$str = "";
foreach ($keys as $i)
    $str .= $arr[$i];
$_SESSION["randValid"] = $str;
for ($i = 0; $i < $times * 2; $i++) {
    $color = imagecolorallocate($img, rand(0, 156), rand(0, 156), rand(0, 156));//干扰像素颜色
    imageline($img, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $color);
    $color = imagecolorallocate($img, rand(0, 255), rand(0, 255), rand(0, 255));
    imagesetpixel($img, rand(0, $width), rand(0, $height), $color);
}
$color = imagecolorallocate($img, 255, 255, 255);
imagestring($img, 5, 5, 3, $str, $color);
header("content-type:image/png");
imagepng($img);
imagedestroy($img);
?>