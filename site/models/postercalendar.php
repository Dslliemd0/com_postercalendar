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

use Joomla\CMS\Factory;

/**
 * PosterCalendar Model
 *
 * @since  0.0.1
 */
class PosterCalendarModelPosterCalendar extends JModelList
{
	/**
	 * @var string message
	 */
	protected $message;

	/**
	 * Get the message
         *
	 * @return  string  The message to be displayed to the user
	 */
	public function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

        $input = JFactory::getApplication()->input;
        $val = $input->get('date', '00-00-0000', 'string');              
				
        if (!isset($this->item)) 
        {
            $id    = $this->getState('message.id');
            $db    = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select($db->quoteName('date'));
            $query->from($db->quoteName('#__poster_calendar_events'));
            $query->where($db->quoteName('published') . ' = ' . $db->quote('1'));
            $db->setQuery((string) $query);

            $results = $db->loadColumn();
        
        }
		return $results;
	}
}