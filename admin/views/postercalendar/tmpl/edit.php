<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_postercalendar
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

?>
<jdoc:include type="message" />

<form action="<?php echo JRoute::_('index.php?option=com_postercalendar&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
    <div class="form-horizontal">

    <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', 
            empty($this->item->id) ? JText::_('COM_POSTERCALENDAR_TAB_NEW_MESSAGE') : JText::_('COM_POSTERCALENDAR_TAB_EDIT_MESSAGE')); ?>
            <fieldset class="adminform">
                <legend><?php echo JText::_('COM_POSTERCALENDAR_POSTERCALENDAR_DETAILS'); ?></legend>
                <div class="row-fluid">
                    <div class="span6">
                        <?php echo $this->form->renderFieldset('main-details');  ?>
                    </div>
                </div>
            </fieldset>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
            
        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'image', JText::_('COM_POSTERCALENDAR_TAB_IMAGE')); ?>
            <fieldset class="adminform">
                <legend><?php echo JText::_('COM_POSTERCALENDAR_LEGEND_IMAGE') ?></legend>
                <div class="row-fluid">
                    <div class="span6">
                        <?php echo $this->form->renderFieldset('image-info');  ?>
                    </div>
                </div>
            </fieldset>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php echo JHtml::_('bootstrap.endTabSet'); ?>

    </div>
    <input type="hidden" name="task" value="postercalendar.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>