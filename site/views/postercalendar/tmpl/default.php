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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

// echo HtmlHelper::date('now', Text::_('DATE_FORMAT_LC4'));

$current_month_days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

?>
<ul id="poster_calendar">
    <?php for ($i = 1; $i <= $current_month_days; $i++): ?>
    <li><?php
        if ($i == date('d')) {
            echo "<a href=\"#\">{$i}</a>";
        } else {
            echo $i;
        }
        ?>
    </li>
    <?php endfor; ?>
</ul>

<?php
foreach ($this->item as $poster) :
?>
<h1><?php echo $poster->title ?>
</h1>
<?php
    $src = $poster->imageDetails['image'];
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
endforeach; ?>