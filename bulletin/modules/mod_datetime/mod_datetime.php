<?php
/**
* Module Joomla! 3.0 Native Component
* @version 1.0
* @author Noah Nguyen
* @link http://melbournedesigncup.com/
* @license GNU/GPL */
//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

//This is the parameter we get from our xml file above
$timeZone = $params->get('mytimezone');
$showTime = $params->get('showtime');
$showDate = $params->get('showdate');
$showname = $params->get('showname');
$showDay = $params->get('showday');

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

//Returns the path of the layout file
require JModuleHelper::getLayoutPath('mod_datetime', $params->get('layout', 'default'));