<?php
/**
* Module Joomla! 3.0 Native Component
* @version 1.0
* @author Noah Nguyen
* @link http://melbournedesigncup.com/
* @license GNU/GPL */
//No access
defined( '_JEXEC' ) or die;

//Add database instance
 

//Pass in query - Limit by the usercount param
$verx  =    $params->get('mytimezone');
date_default_timezone_set($verx);
$dmx =  date_default_timezone_get() . ' => ' . date(' | d/m/Y  | h:i (a) | l'); 

$exmm = explode("|",$dmx);
return $exmm;

