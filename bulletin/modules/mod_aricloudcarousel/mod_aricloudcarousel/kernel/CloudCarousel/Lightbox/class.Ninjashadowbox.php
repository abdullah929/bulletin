<?php
/*
 * ARI Cloud Carousel
 *
 * @package		ARI Cloud Carousel
 * @version		1.0.0
 * @author		ARI Soft
 * @copyright	Copyright (c) 2010 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

AriKernel::import('CloudCarousel.Lightbox.LightboxEngine');

class NinjashadowboxCarouselEngine extends AriCloudCarouselLightboxEngine 
{
	function preCheck()
	{
		$version = new JVersion();
		$j15 = version_compare($version->getShortVersion(), '1.6.0', '<');
		$plgPath = JPATH_ROOT . DS . 'plugins' . DS . 'system' . DS . (!$j15 ? 'ninja.shadowbox' . DS : '') . 'ninja.shadowbox.php';
		if (!@file_exists($plgPath))
		{
			$mainframe =& JFactory::getApplication();

			$mainframe->enqueueMessage('<b>ARI Cloud Carousel</b>: "System - Ninja Shadowbox" plugin isn\'t installed.');
			
			return false;
		}
		
		return true;
	}
	
	function modifyAttrs($lnkAttrs, $imgAttrs, $group, $params)
	{
		$lnkAttrs['rel'] = 'shadowbox';
		if ($group)
			$lnkAttrs['rel'] .= '[' . $group . ']';
			
		$link = $lnkAttrs['href'];
		if ($this->isLink($link))
		{
			$lnkAttrs['rel'] .= ';height=' . intval($params->get('lightbox_height'), 10);
			$lnkAttrs['rel'] .= ';width=' . intval($params->get('lightbox_width'), 10);
		}

		return parent::modifyAttrs($lnkAttrs, $imgAttrs, $group, $params);
	}
}
?>