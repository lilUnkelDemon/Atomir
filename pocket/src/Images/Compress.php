<?php

namespace Atomir\AtomirCore\Images;

class Compress
{
    public function compressImage($source, $destination, $quality)
    {
        $info = getimagesize($source);

        if ($info === false) {
            die('Unable to get image info.');
        }
        if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/jpg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
            $quality = floor($quality / 10);
        } else {
            die('Unsupported file format.');
        }

        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $pathInfo = pathinfo($source);
        $originalFileName = $pathInfo['filename'];
        $extension = $pathInfo['extension'];
        $RandomString = $this->generateRandomName(15);
        $FileName = 'compress_' . $RandomString . $originalFileName;
        if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/jpg') {
            $FileName .= '.jpg';
        } elseif ($info['mime'] == 'image/png') {
            $FileName .= '.png';
        }


        $destinationPath = $destination . '/' . $FileName;
        if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/jpg') {
            imagejpeg($image, $destinationPath, $quality);
        } elseif ($info['mime'] == 'image/png') {
            imagepng($image, $destinationPath, $quality);
        }

        imagedestroy($image);
        return $destinationPath;
    }



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