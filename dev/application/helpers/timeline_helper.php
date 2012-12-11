<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppHelpers
 */

/**
 * Creates slider background image.
 * 
 * @param string $texture_file path to file with image placed in background.
 * @param integer $min_year minimum year in slider.
 * @param integer $max_year maximum year in slider.
 * @param string $bg_color background color value in hex notation.
 * @param string $number_color color value for number segments in hex notation.
 * @param integer $width image width.
 * @param integer $height image height.
 * @return string path to background image.
 */
function createSlidebBackgroundImage($texture_file, $min_year = 0, $max_year = 1000, $bg_color = '000000', $number_color = 'ffffff', $width = 20, $height = 400) {
    $sha_hash = sha1($texture_file . '-' . $min_year . '-' . $max_year . '-' . $bg_color . '-' . $number_color . '-' . $width . '-' . $height);
    $path_to_cache = 'public/timeline/' . $sha_hash . '.png';
    
    $cache_valid = FALSE;
    if (file_exists($path_to_cache)) {
        $cache_valid = TRUE;
    }
        
    $image_bg = NULL;
    if ($texture_file !== '' || $texture_file !== NULL) {
        if (file_exists($texture_file)) {
            $my_cache_file_time = file_exists($path_to_cache) ? filemtime($path_to_cache) : 0;
            $texture_file_time = filemtime($texture_file);
            if ($texture_file_time > $my_cache_file_time) {
                $image_bg = getGD2ImageFromFile($texture_file);
                $cache_valid = FALSE;               
            }
        } else {
            $cache_valid = FALSE;
        }
    }
    
    $base_url = trim(Abstract_common_controller::getBaseUrl(), '/\\');
    
    if ($cache_valid) {
        return $base_url . '/' . $path_to_cache;
    }
    
    $image = imagecreatetruecolor($width, $height);
    
    getRGBFromHexColor($bg_color, $bg_red, $bg_green, $bg_blue);
    $color_background = imagecolorallocate($image, $bg_red, $bg_green, $bg_blue);
    getRGBFromHexColor($number_color, $nm_red, $nm_green, $nm_blue);
    $color_number = imagecolorallocate($image, $nm_red, $nm_green, $nm_blue);
    
    
    if ($image_bg !== NULL) {
        $image_info = getimagesize($texture_file);
        $dest_x = ($width / 2) - ($image_info[0] / 2);
        $dest_y = ($height / 2) - ($image_info[1] / 2); 
        imagecopy($image, $image_bg, $dest_x, $dest_y, 0, 0, $image_info[0], $image_info[1]);
    }
    
    $range = $max_year - $min_year;
    
    for($i = $min_year; $i <= $max_year; $i++) {
        imagesetthickness($image, 3);
        if ($i % 1000 == 0) {
            $y_coord = getYCoordinate($i, $min_year, $max_year, $height);
            imageline($image, $width, $y_coord, 0, $y_coord, $color_number);
        } elseif ($i % 100 == 0) {
            $y_coord = getYCoordinate($i, $min_year, $max_year, $height);
            imageline($image, $width, $y_coord, $width / 3, $y_coord, $color_number);
        } elseif ($i % 50 == 0 && $range <= 1000) {
            $y_coord = getYCoordinate($i, $min_year, $max_year, $height);
            imageline($image, $width, $y_coord, $width / 2, $y_coord, $color_number);
        } elseif ($i % 10 == 0 && $range <= 500) {
            imagesetthickness($image, 2);
            $y_coord = getYCoordinate($i, $min_year, $max_year, $height);
            imageline($image, $width, $y_coord, $width / 5 * 3, $y_coord, $color_number);
        } elseif ($i % 2 == 0 && $range <= 50) {
            imagesetthickness($image, 2);
            $y_coord = getYCoordinate($i, $min_year, $max_year, $height);
            imageline($image, $width, $y_coord, $width / 5 * 4, $y_coord, $color_number);
        }
    }
    
    imagepng($image, $path_to_cache, 9);
    
    return $base_url . '/' . $path_to_cache;
}

/**
 * Calculate color components from color in hex notation.
 * 
 * @param string $hex_color color in hex notation.
 * @param integer $red return value of red component.
 * @param integer $green return value of green component.
 * @param integer $blue return value of blue component.
 * @return void
 */
function getRGBFromHexColor($hex_color, &$red, &$green, &$blue) {
    $red = 0;
    $green = 0;
    $blue = 0;
    
    $hex_color = ltrim(strtolower($hex_color), '#');
    
    $red = hexdec(substr($hex_color, 0, 2));
    $green = hexdec(substr($hex_color, 2, 2));
    $blue = hexdec(substr($hex_color, 4, 2));
}

/**
 * Calculates y coordinate of given value.
 * 
 * @param integer $value value to calculate from.
 * @param integer $min_year minimum year at timeline.
 * @param integer $max_year maximum year at timeline.
 * @param integer $height height of image.
 * @return double calculated value.
 */
function getYCoordinate($value, $min_year, $max_year, $height) {
    $range = $max_year - $min_year;
    $range_sample = $height / $range;
    $value_to_compute = $max_year - $value;
    return $value_to_compute * $range_sample;
}

/**
 * Creates gd2 image resource by file extension.
 * Returns NULL on error.
 * 
 * @param string $file path to file.
 * @return resource gd2 image or NULL on error.
 */
function getGD2ImageFromFile($file) {
    if (!file_exists($file)) { return NULL; }
    $info = pathinfo($file);
    try {
        if ($info['extension'] == 'gif') {
            return imagecreatefromgif($file);
        } elseif ($info['extension'] == 'jpg' || $info['extension'] == 'jpeg') {
            return imagecreatefromjpeg($file);
        } elseif ($info['extension'] == 'png') {
            return imagecreatefrompng($file);
        }
    } catch (Exception $e) {
        return NULL;
    }
    return NULL;
}
 
?>