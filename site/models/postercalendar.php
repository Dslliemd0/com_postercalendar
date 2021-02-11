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
 * PosterCalendar Model
 *
 * @since  0.0.1
 */
class PosterCalendarModelPosterCalendar extends JModelItem
{
	/**
	 * @var array messages
	 */
	protected $messages;

	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'PosterCalendar', $prefix = 'PosterCalendarTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Get the message
	 * @return object The message to be displayed to the user
	 */
	public function getItem()
	{
		if (!isset($this->item)) 
		{
			$id    = $this->getState('message.id');
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('id', 'title', 'date', 'image', 'thumb')));
			$query->from($db->quoteName('#__poster_calendar_events'));
			$db->setQuery((string) $query);

			$results = $db->loadObjectList();
		
			foreach ($results as $item) 
			{

				// Convert the JSON-encoded image info into an array
				$image = new JRegistry;
				$image->loadString($item->image, 'JSON');
				$item->imageDetails = $image;
			}

			
		}
		return $results;
	}

}