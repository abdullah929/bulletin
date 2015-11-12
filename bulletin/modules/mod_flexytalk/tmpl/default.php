<?php
/**
 * @package 	Module Frescochat enables you to chat to your web visitors using any popular IM app for desktop or mobile devices. Free lifetime plan with unlimited chats.
 * @version 	1.0
 * @author 	Sebastian Odena
 * @copyright 	Copyright (C) 2013 frescochat.com. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @Contact to : http://www.frescochat.com
 **/
// no direct access
defined('_JEXEC') or die('Restricted access');

	//Get all params value
	
	$widget_id = $params->get( 'widget_id' );

  

	// HTML generation code
	echo $htmlCode="<script id='fresco_script' data-frescochat='".$widget_id."'>
         var frescochat_script = document.createElement('script');
         frescochat_script.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//frescochat.blob.core.windows.net/app/v3/js/frescochat.js';
      
         document.getElementsByTagName('head')[0].appendChild(frescochat_script);
   </script>";
?>	