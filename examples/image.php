<?php

require __DIR__ . '/../vendor/autoload.php';

$colors = [
  '#CBFF8C',
  '#E3E36A',
  '#C16200',
  '#881600',
  '#4E0110',
];

shuffle($colors);

use BurberryPlaid\Image;

$generator = new Image();

try {
  $image = $generator->generate(100, 100, array_slice($colors, 0 , 3));

  header('Content-type: image/png');
  echo $image;

  $image->destroy();
} catch (Exception $e) {
  echo $e->getMessage();
}
