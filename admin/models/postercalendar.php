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

jimport('joomla.client.helper');
JClientHelper::setCredentialsFromRequest('ftp');		
jimport('joomla.filesystem.file');


use Joomla\Registry\Registry;

/**
 * PosterCalendar Model
 *
 * @since  0.0.1
 */
class PosterCalendarModelPosterCalendar extends JModelAdmin
{
	/**
	 * Method to override getItem to allow us to convert the JSON-encoded image information
	 * in the database record into an array for subsequent prefilling of the edit form
	 */
	public function getItem($pk = null)
	{
		$item = parent::getItem($pk);
		if ($item AND property_exists($item, 'image'))
		{
			$registry = new Registry($item->image);
			$item->imageinfo = $registry->toArray();
		}
		return $item; 
	}
	
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
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed    A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm(
			'com_postercalendar.postercalendar',
			'postercalendar',
			array(
				'control' => 'jform',
				'load_data' => $loadData
			)
		);

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the script that have to be included on the form
	 *
	 * @return string	Script files
	 */
	public function getScript() 
	{
		return 'administrator/components/com_postercalendar/models/forms/postercalendar.js';
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState(
			'com_postercalendar.edit.postercalendar.data',
			array()
		);

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}

	public function save($data)
	{
		JRequest::checkToken() or die( 'Invalid Token' );

		$file = JFactory::getApplication()->input->files->get('jform');

		jimport('joomla.filesystem.file');

		$src = $file['imageinfo']['image']['tmp_name'];
		$filename = $file['imageinfo']['image']['name'];

		$image_data = $data['imageinfo'];

		$filename = PosterCalendarHelper::combineFileNameDate($filename, $data['date']);

		$date_array = explode('-', $data['date']);

		if ($filename != '' && PosterCalendarHelper::isImage($filename)) {

			$rel_path = "/images/postercalendar/" . $date_array[0] . "/" . $filename;

			// Make sure that the full file path is safe.
			$filepath = JPath::clean(JPATH_ROOT . $rel_path);

			$resize_file_path = $filepath;
	
			// Move the uploaded file.
			if (JFile::upload($src, $filepath)) {

				PosterCalendarHelper::resize_image($resize_file_path);

				$new_order = array('image' => $rel_path) + $data['imageinfo'];
				$data['imageinfo'] = $new_order;
			} else {              
				JError::raiseError( 4711, 'Error uploading file.' );
			}        
		} else {
			JError::raiseError( 4711, 'The file you are trying to upload is not supported');
		}

		JRequest::setVar('jform', $data, 'post');

		return parent::save($data);
	}
}