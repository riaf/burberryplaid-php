<?php

namespace BurberryPlaid;

use Imagick;
use ImagickPixel;
use ImagickDraw;

class Image
{
    public function generate(int $x, int $y, array $colors = [
        '#b39d62',
        '#45402d',
        '#e8eedc',
    ], string $background = 'white'): Imagick
    {
        if (count($colors) !== 3) {
            throw new \InvalidArgumentException('$colors length must be 3');
        }

        $image = new Imagick();

        // new image.
        $image->newImage(
            $x,
            $y,
            new ImagickPixel($background)
        );

        // default format
        $image->setImageFormat('png');

        // enable matte channel
        $image->setImageMatte(true);

        $pattern = $this->createPattern($x, $y, $colors);

        $image->drawImage($pattern);
        $image->rotateImage('none', -90);

        $image->drawImage($pattern);

        return $image;
    }

    private function createPattern(int $width, int $h, array $colors): ImagickDraw
    {
        $pattern = new ImagickDraw();

        $pattern->setStrokeWidth(0);
        $pattern->setStrokeColor('none');

        $y = 0;
        $baseHeight = $h / 10;

        foreach ([
            [0, 2],
            [1, 1],
            [2, 1],
            [1, 1],
            [2, 1],
            [1, 1],
            [0, 2],
            [1, 1]
        ] as list($i, $rows)) {
            $height = $baseHeight * $rows;

            $pattern->setFillColor($colors[$i]);
            $pattern->setFillOpacity(0.5);
            $pattern->rectangle(0, $y, $width, $y + $height - 1);

            $y += $height;
        }

        return $pattern;
    }
}
