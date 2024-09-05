<?php

namespace Atomir\AtomirCore\Images;

class Avatar
{

    // Generate Random Avatar //
    function generateRandomAvatar($width = 250, $height = 250, $blockSize = 10,$destintaion) {

        $image = imagecreatetruecolor($width, $height);

        $backgroundColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
        imagefill($image, 0, 0, $backgroundColor);

        for ($i = 0; $i < $width; $i += $blockSize) {
            for ($j = 0; $j < $height; $j += $blockSize) {
                if (rand(0, 1)) {
                    $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
                    imagefilledrectangle($image, $i, $j, $i + $blockSize - 1, $j + $blockSize - 1, $color);
                }
            }
        }

        $RandomName = $this->generateRandomName(25);
        $fileName = 'avatar_' . $RandomName . '.png';



        if (!is_dir($destintaion)) {
            mkdir($destintaion, 0755, true);
        }

        $destinationPath = $destintaion . '/' . $fileName;

        imagepng($image, $destinationPath);

        imagedestroy($image);

        return $destinationPath;
    }

    // Generate Random Avatar //


    // Generate Concept Avatar
    function generateConceptAvatar($width = 250, $height = 250, $blockSize = 10, $destination) {
        $image = imagecreatetruecolor($width, $height);

        $backgroundColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
        $borderColor = imagecolorallocate($image, 0, 0, 0);
        imagefill($image, 0, 0, $backgroundColor);

        for ($i = 0; $i < $width; $i += $blockSize) {
            for ($j = 0; $j < $height; $j += $blockSize) {
                if (rand(0, 1)) {
                    $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
                    imagefilledrectangle($image, $i, $j, $i + $blockSize - 1, $j + $blockSize - 1, $color);
                }
            }
        }

        $circleDiameter = min($width, $height) - 20;
        $circleRadius = $circleDiameter / 2;
        $circleX = $width / 2;
        $circleY = $height / 2;

        imagefilledellipse($image, $circleX, $circleY, $circleDiameter, $circleDiameter, $backgroundColor);
        imageellipse($image, $circleX, $circleY, $circleDiameter, $circleDiameter, $borderColor);

        $shapeColor = imagecolorallocate($image, 255, 0, 0); // رنگ شکل

        $headRadius = $circleRadius * 0.4;
        imagefilledellipse($image, $circleX, $circleY, $headRadius * 2, $headRadius * 2, $shapeColor);

        $eyeRadius = $headRadius * 0.1;
        $eyeXOffset = $headRadius * 0.4;
        $eyeYOffset = $headRadius * 0.2;
        imagefilledellipse($image, $circleX - $eyeXOffset, $circleY - $eyeYOffset, $eyeRadius * 2, $eyeRadius * 2, $backgroundColor);
        imagefilledellipse($image, $circleX + $eyeXOffset, $circleY - $eyeYOffset, $eyeRadius * 2, $eyeRadius * 2, $backgroundColor);

        $mouthWidth = $headRadius * 0.6;
        $mouthHeight = $headRadius * 0.2;
        imagearc($image, $circleX, $circleY + $eyeYOffset, $mouthWidth, $mouthHeight, 0, 180, $backgroundColor);

        $RandomName = bin2hex(random_bytes(12));
        $fileName = 'avatar_' . $RandomName . '.png';

        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $destinationPath = $destination . '/' . $fileName;

        imagepng($image, $destinationPath);

        imagedestroy($image);

        return $destinationPath;
    }
    // Generate Concept Avatar


    // random name generator //
    function generateRandomName($length) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
    // random name generator //
}