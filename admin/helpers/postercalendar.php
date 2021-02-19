<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_postercalendar
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * PosterCalendar component helper.
 *
 * @param   string  $submenu  The name of the active view.
 *
 * @return  void
 *
 * @since   1.6
 */
abstract class PosterCalendarHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @return Bool
	 */

    protected static function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyz',
                                            ceil($length/strlen($x)) )),1,$length);
    }

    public static function isImage($file) {

        switch (JFile::getExt($file)) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                return true;
                break;
            default:
                return false;
        }
    }

	public static function sanitizeFileName($filename) 
	{
		$filename_array = explode('.', $filename);
	
        $base_filename = "";
        
        for ($i = 0; $i < count($filename_array) - 1; $i++) {
            $base_filename .= $filename_array[$i];
        }
        
        if (function_exists('transliterator_transliterate')) {
			$base_filename = transliterator_transliterate('Any-Latin; Latin-ASCII;', $base_filename);
		} else {
			$base_filename = JLanguageTransliterate::utf8_latin_to_ascii($base_filename);
		}

        $base_filename = str_replace(" ", "_", $base_filename);
        
        $file_extension = $filename_array[count($filename_array) - 1];

        $base_filename = JFile::makeSafe($base_filename);
        $file_extension = JFile::makeSafe($file_extension);
    
        /** This filter is documented in wp-includes/formatting.php */
        return JString::strtolower($base_filename . "." . $file_extension);
	}

    public static function combineFileNameDate($filename, $date) 
	{
		$filename_array = explode('.', $filename);
        
        $file_extension = $filename_array[count($filename_array) - 1];

        $file_extension = JString::strtolower($file_extension);

        return $date . "_" . PosterCalendarHelper::generateRandomString() . "." . $file_extension;
	}

    public static function isLandscape($filename) {
        list($width, $height) = getimagesize($filename);

        if ($width > $height) {
            return true;
        } else {
            return false;
        }
    }

    public static function resize_image($file_name) {

        list($width, $height, $type) = getimagesize($file_name);

        $new_height = 900;

        

        if ($height > $new_height) {

            switch ($type) {
                case IMAGETYPE_JPEG:
                    $image = imagecreatefromjpeg($file_name);
                    break;
                case IMAGETYPE_PNG:
                    $image = imagecreatefrompng($file_name);
                    break;
                case IMAGETYPE_GIF:
                    $image = imagecreatefromgif($file_name);
                    break;
            }
        
            $ratio = $new_height / $height;
            $new_width = $width * $ratio;
    
            $new_image = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
            switch ($type) {
                case IMAGETYPE_JPEG:
                    imagejpeg($new_image, $file_name, 100);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($new_image, $file_name);
                    break;
                case IMAGETYPE_GIF:
                    imagegif($new_image, $file_name);
                    break;
            }
            return true;
        } else {
            return false;
        }
    }
}