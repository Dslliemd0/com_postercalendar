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

?>

<?php if (isset($this->item) && count($this->item)) : ?>
    <?php 
        foreach ($this->item as $poster) :
    ?>
	<h1><?php echo $poster->title ?></h1>
    <?php
        $src = JURI::root() . ($poster->imageDetails['image']);
        if ($src)
        {
            $html = '<figure>
                        <img src="%s" alt="%s" >
                        <figcaption>%s</figcaption>
                    </figure>';
            $alt = $poster->imageDetails['alt'];
            $caption = $poster->imageDetails['caption'];
            echo sprintf($html, $src, $alt, $caption);
        } 
    endforeach;?>
<?php else: ?>
    <p><?php echo JText::_('COM_POSTERCALENDAR_POSTERS_NO_ITEM_NOTIFICATION'); ?></p>
<?php endif; ?>
