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

/**
 * PosterCalendar Table class
 *
 * @since  0.0.1
 */
class PosterCalendarTablePosterCalendar extends JTable
{
	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  &$db  A database connector object
	 */
	function __construct(&$db)
	{
		parent::__construct('#__poster_calendar_events', 'id', $db);
	}

	/**
	 * Overloaded bind function
	 *
	 * @param       array           named array
	 * @return      null|string     null is operation was satisfactory, otherwise returns an error
	 * @see JTable:bind
	 * @since 1.5
	 */
	public function bind($array, $ignore = '')
	{
		if (isset($array['imageinfo']) && is_array($array['imageinfo']))
		{
			// Convert the imageinfo array to a string.
			$parameter = new JRegistry;
			$parameter->loadArray($array['imageinfo']);
			$array['image'] = (string)$parameter;
		}

		return parent::bind($array, $ignore);
	}
}