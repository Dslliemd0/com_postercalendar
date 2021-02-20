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
class PosterCalendarModelPosters extends JModelList
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
            $query->select($db->quoteName(array('id', 'title', 'date', 'image', 'thumb')));
            $query->from($db->quoteName('#__poster_calendar_events'));
            $query->where($db->quoteName('date') . ' = ' . $db->quote($val));
            $query->where($db->quoteName('published') . ' = ' . $db->quote('1'));
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