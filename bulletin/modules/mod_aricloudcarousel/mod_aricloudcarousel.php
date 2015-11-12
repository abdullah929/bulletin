<?php
/*
 * ARI Cloud Carousel Joomla! module
 *
 * @package		ARI Cloud Carousel Joomla! module.
 * @version		1.0.0
 * @author		ARI Soft
 * @copyright	Copyright (c) 2010 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

defined('_JEXEC') or die('Restricted access');

require_once dirname(__FILE__) . '/mod_aricloudcarousel/kernel/class.AriKernel.php';

AriKernel::import('CloudCarousel.CloudCarousel');
AriKernel::import('Web.HtmlHelper');

$fixedId = (bool)$params->get('fixedId', false);

$carouselId = $fixedId ? 'acc_' . $module->id : uniqid('acc_', false);
AriCloudCarouselHelper::initCarousel($carouselId, $params);

$slides = AriCloudCarouselHelper::prepareSlides(
	AriCloudCarouselHelper::getSlides($params),
	$params);

require JModuleHelper::getLayoutPath('mod_aricloudcarousel');