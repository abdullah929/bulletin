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

class CorejoomlalightboxCarouselEngine extends AriCloudCarouselLightboxEngine 
{	
	function modifyAttrs($lnkAttrs, $imgAttrs, $group, $params)
	{
		JHTML::_('behavior.modal', 'a.modal');
		
		if (empty($lnkAttrs['class']))
			$lnkAttrs['class'] = '';
		else
			$lnkAttrs['class'] .= ' ';
			
		$lnkAttrs['class'] .= 'modal';
			
		$link = $lnkAttrs['href'];
		if ($this->isLink($link))
		{
			$lnkParams = array('handler' => 'iframe', 'size' => array('x' => $params->get('lightbox_width'), 'y' => $params->get('lightbox_height')));
			$lnkAttrs['rel'] = str_replace('"', '&quot;', AriJSONHelper::encode($lnkParams));
		}

		return parent::modifyAttrs($lnkAttrs, $imgAttrs, $group, $params);
	}
}
?>