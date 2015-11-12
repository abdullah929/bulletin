<?php
/**
 * @package 	Module Frescochat enables you to chat to your web visitors using any popular IM app for desktop or mobile devices. Free lifetime plan with unlimited chats.
 * @version 	1.0
 * @author 	FrescoChat
 * @copyright 	Copyright (C) 2013 flexytalk.com. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @Contact to : http://www.frescochat.com
 **/

// no direct access

defined('_JEXEC') or die('Restricted access');

class JFormFieldListfields extends JFormField{
 
	function getInput() // default function for custom parameters
	{
	    //to add images for admin site of the  module
	    $image_name=array('black-tie.png','blitzer.png','cupertino.png','dark-hive.png','dot-luv.png','eggplant.png','excite-bike.png','flick.png','hot-sneaks.png','humanity.png','lefrog.png','mint-choc.png','overcast.png','pepper-grinder.png','redmond.png','smoothness.png','south-street.png','start.png','sunny.png','swanky-purse.png','trontastic.png','ui-darkness.png','ui-lightness.png','vader.png');
		$tree='';$checked='';
		$tree.='<div style=""><table><tr>';
		for($i=1;$i<=24;$i++){
			
			if($this->value==$i)
			{
				$checked="checked='checked'";
			}
			else{
				$checked='';
			}
		$tree.='<td>';
		$tree.='<input type="radio" name="'.$this->name.'" id="radioId'.$i.'" value="'.$i.'" '.$checked.' ><img src="'.JURI::root().'modules/mod_flexytalk/fields/img/'. $image_name[$i-1].'">';
		$tree.='</td>';
		
		if($i%2==0){$tree.='</tr><tr>';}
		}
		$tree.='</tr></table></div>';
		return $tree;
	}//end	
}?>
