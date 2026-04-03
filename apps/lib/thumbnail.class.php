<?php

class thumbnail {

	  static public function create($source,$dest,$thumbSize) 
	  {
		$y = NULL;
		$x = NULL;

		$thumb_size = $thumbSize;

		$size = getimagesize($source);
		$width = $size[0];
		$height = $size[1];

		if($width > $height) {
			$x = ceil(($width - $height) / 2 );
			$width = $height;
		} elseif($height > $width) {
			$y = ceil(($height - $width) / 2);
			$height = $width;
		}

		$new_im = ImageCreatetruecolor($thumb_size,$thumb_size);
		$im = imagecreatefromjpeg($source);
		imagecopyresampled($new_im,$im,0,0,$x,$y,$thumb_size,$thumb_size,$width,$height);
		imagejpeg($new_im,$dest,100);
	  }
}
