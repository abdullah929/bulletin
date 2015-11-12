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
AriKernel::import('Web.JSON.JSONHelper');

class ArifancyboxCarouselEngine extends AriCloudCarouselLightboxEngine 
{
	function preCheck()
	{
		$version = new JVersion();
		$j15 = version_compare($version->getShortVersion(), '1.6.0', '<');
		$plgPath = JPATH_ROOT . DS . 'plugins' . DS . 'system' . DS . (!$j15 ? 'arifancybox' . DS : '') . 'arifancybox.php';
		if (!@file_exists($plgPath))
		{
			$mainframe =& JFactory::getApplication();

			$mainframe->enqueueMessage('<b>ARI Cloud Carousel</b>: "System - ARI Fancybox" plugin isn\'t installed.');
			
			return false;
		}
		
		return true;
	}
	
	function modifyAttrs($lnkAttrs, $imgAttrs, $group, $params)
	{
		if ($group)
			$lnkAttrs['rel'] = $group;
			
		if (empty($lnkAttrs['class']))
			$lnkAttrs['class'] = '';
		else
			$lnkAttrs['class'] .= ' ';
			
		$lnkAttrs['class'] .= 'arifancybox';

		$link = $lnkAttrs['href'];
		if ($this->isLink($link))
		{
			$uri = new JURI($link);
			$lnkParams = array(
				'width' => intval($uri->getVar('width') ? $uri->getVar('width') : $params->get('lightbox_width'), 10), 
				'height' => intval($uri->getVar('height') ? $uri->getVar('height') : $params->get('lightbox_height'), 10)
			);
			$lnkAttrs['class'] .= ' iframe ' . str_replace('"', '&quot;', AriJSONHelper::encode($lnkParams));

			$uri->delVar('width');
			$uri->delVar('height');
			
			$lnkAttrs['href'] = $uri->toString();			
		}

		return parent::modifyAttrs($lnkAttrs, $imgAttrs, $group, $params);
	}
}
?>