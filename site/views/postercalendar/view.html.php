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
 * HTML View class for the PosterCalendar Component
 *
 * @since  0.0.1
 */
class PosterCalendarViewPosterCalendar extends JViewLegacy
{
	/**
	 * Display the Posters view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */

	function display($tpl = null)
	{
		// Assign data to the view
		$this->item = $this->get('ListQuery');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

			return false;
		}

		// Display the view
        parent::display($tpl);
        
        $this->setDocument();
    }

    protected function setDocument() 
	{
        JHtml::_('jquery.framework', false);
        
        $document = JFactory::getDocument();
        $document->addScript('https://cdn.jsdelivr.net/npm/moment@latest/min/moment-with-locales.min.js');
        $document->addScript(JURI::root() . "components/com_postercalendar"
		                                  . "/views/postercalendar/rescalendar.js");
	}
}