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

echo $this->item;

?>
<h1>Posters view</h1>
<div class="rescalendar" id="example"></div>

<div id="horizontal-calendar"></div>
<div class="uk-article"></div>


<script>

const eventData = [
	{
		id: 1,
		name:'item1',
		startDate:'05-02-2021',
		endDate:'08-02-2021',
		customClass:'yourClass'
	},
	{
		id: 2,
		name:'item2',
		startDate:'25-02-2021',
		endDate:'25-02-2021',
		customClass:'yourClass',
		title:'Title 2'
	},
	{
		id: 3,
		name:'item5-5',
		startDate:'05-01-2021',
		endDate:'15-01-2021',
		customClass:'yourClass'
	}
]



$('#example').rescalendar({
	id:'example',
	format:'DD-MM-YYYY',
	data: eventData,
	dataKeyField:'name',
	dataKeyValues: ['item1','item2','item3'],
	locale:'en',

	// initial date
	refDate: moment().format('DD-MM-YYYY' ),

	// the number of days to move on click
	jumpSize: 15,

	// calendar size
	calSize: 30,

	// disabled days
	disabledDays : [],

	// 0 = Sunday
	disabledWeekDays: [],

	// language strings
	lang: {
		'init_error' :'Error when initializing',
		'no_data_error':'No data found',
		'no_ref_date'  :'No refDate found',
		'today'   :'Today'
	}

});

</script>
