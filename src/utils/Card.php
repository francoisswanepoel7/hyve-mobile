<?php
namespace hyvemobile\utils;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Adapter\RedisTagAwareAdapter;
use Symfony\Contracts\Cache\ItemInterface;


class Card
{

    public function make(string $firstName, string $lastName, string $email) {
        $filename = 'cards/'.$email.'.jpg';
        if (!file_exists($filename)) {
            $image = imagecreate(500, 300);
            $background_color = imagecolorallocate($image, 0, 153, 0);
            $text_color = imagecolorallocate($image, 255, 255, 255);
            imagestring($image, 5, 180, 100, $firstName . ' ' . $lastName, $text_color);
            imagestring($image, 3, 160, 120, $email, $text_color);
            imagejpeg($image, 'cards/' . $email . '.jpg');
        }
        return $filename;
    }

    public function getBase64EncodedImage($fileName) {
        $key = str_replace('cards/','card_', $fileName);
        $key = str_replace('@','_', $key);
        return base64_encode(file_get_contents($fileName));
//        $base64_encoded = '';
//        try {
//            $base64_encoded = $this->cache->get($key, function (ItemInterface $item) use ($fileName) {
//                $item->expiresAfter(84600);
//                return base64_encode(file_get_contents($fileName));
//            });
//        } catch (InvalidArgumentException $e) {
//            echo $e->getMessage();
//        }
//        return $base64_encoded;
    }

}
