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

jimport('joomla.filter.filterinput');

AriKernel::import('Utils.Utils');
AriKernel::import('Utils.AppUtils');
AriKernel::import('Web.JSON.JSONHelper');
AriKernel::import('FileSystem.Folder');
AriKernel::import('Image.ImageHelper');

class AriCloudCarouselHelper
{
	function includeAssets($params)
	{
		static $loaded;

		if ($loaded)
			return ;
			
		$loadJQuery = (bool)$params->get('includeJQuery', true);
		$noConflict = (bool)$params->get('noConflict', true);
		$theme = $params->get('theme', '');

		$doc =& JFactory::getDocument();
		$baseUri = JURI::root(true) . '/modules/mod_aricloudcarousel/mod_aricloudcarousel/js/';
		if ($loadJQuery) 
		{
			$loadJQueryMethod = $params->get('loadJQueryMethod', 'google_cdn');
			if ($loadJQueryMethod == 'local')
			{
				if (J3_0)
					JHtml::_('jquery.framework', $noConflict);
				else
					$doc->addScript($baseUri . 'jquery.min.js');
			}
			else
			{ 
				$jQueryVer = $params->get('jQueryVer', '1.4.4');
				$doc->addScript('http://ajax.googleapis.com/ajax/libs/jquery/' . $jQueryVer . '/jquery.min.js');
			}

			if ($noConflict)
			{
				$doc->addScript($baseUri . 'jquery.noconflict.js');
			}
		}

		$doc->addScript($baseUri . 'jquery.mousewheel.min.js');
		$doc->addScript($baseUri . 'jquery.cloud-carousel.min.js');
		$doc->addScript($baseUri . 'init.js');

		$theme = JFilterInput::clean($theme, 'WORD');
		if (empty($theme)) $theme = 'default';

		$doc->addStyleSheet($baseUri . 'themes/' . $theme . '/style.css');
		if (@file_exists(JPATH_ROOT . DS . 'modules' . DS . 'mod_aricloudcarousel' . DS . 'mod_aricloudcarousel' . DS . 'js' . DS . 'themes' . DS . $theme . DS . 'style.ie6.css'))
		{
			$doc->addCustomTag(
				sprintf('<!--[if lt IE 7]><link rel="stylesheet" href="%s" type="text/css" /><![endif]-->',
					$baseUri . 'themes/' . $theme . '/style.ie6.css')
			);
		}

		$loaded = true;
	}
	
	function initCarousel($id, $params)
	{
		AriCloudCarouselHelper::includeAssets($params);

		$width = intval($params->get('width', 300), 10);
		$height = intval($params->get('height'), 10);
		
		$width .= (strpos($params->get('width'), '%') !== false) ? '%' : 'px';

		$clientParams = AriCloudCarouselHelper::getClientParams($params);
		$doc =& JFactory::getDocument();
		
		$doc->addScriptDeclaration(
			sprintf(';(window["jQueryCloudCarousel"] || jQuery)(document).ready(function($) { cloudCarouselInit(window.jQueryCloudCarousel || $, "#%1$s", "%3$s", $.extend(%2$s, {"buttonLeft": $("#%1$s_wrapper .ari-cloud-carousel-left"), "buttonRight": $("#%1$s_wrapper .ari-cloud-carousel-right"), "titleBox": $("#%1$s_wrapper .ari-cloud-carousel-title"), "altBox": $("#%1$s_wrapper .ari-cloud-carousel-alt")}),%4$s); });',
				$id,
				$clientParams ? AriJSONHelper::encode($clientParams) : '{}',
				$width,
				(bool)$params->get('openOnlyActive', false) ? 'true' : 'false')
		);
		
		$styleDec = sprintf('#%1$s_wrapper,#%1$s{width:%2$s;height:%3$dpx;}',
			$id,
			$width,
			$height);
			
		if ($params->get('customstyle'))
		{
			$extraStyles = trim($params->get('customstyle'));
			$extraStyles = str_replace('{$id}', '#' . $id, $extraStyles);
			if (!empty($extraStyles))
				$styleDec .= $extraStyles;
		}
		
		$bgImage = $params->get('bgImage');
		if ($bgImage)
			$styleDec .= sprintf('#%1$s_wrapper{background:transparent url(%2$s) no-repeat center center;}',
				$id,
				AriUtils::isRemoteResource($bgImage) ? $bgImage : JURI::root(true) . '/' . $bgImage);
		
		$doc->addStyleDeclaration($styleDec);
	}
	
	function getClientParams($params)
	{
		$clientParams = array(
			'minScale' => 0.5,
			'reflHeight' => 0,
			'reflGap' => 0,
			'reflOpacity' => 0.0,
			'xRadius' => 0.0,
			'yRadius' => 0.0,
			'xPos' => 0,
			'yPos' => 0,
			'FPS' => 30,
			'speed' => 0.2,
			'autoRotate' => 'no',
			'autoRotateDelay' => 1500,
			'mouseWheel' => false,
			'reverseMouseWheel' => false,
			'bringToFront' => false,
			'keyboardNav' => false,
			'reverseKeyboardNav' => false,
			'startIndex' => 0,
			'onlyFrontDescription' => false,
			'disableTimer' => true,
			'stopInBackground' => false
		);
		
		$sliderParams = array();
		foreach ($clientParams as $key => $value)
		{
			$param = $params->get('opt_' . $key, null);
			if (is_null($param))
				continue ;
				
			$param = AriUtils::parseValueBySample($param, $value);
			if ($value !== $param)
				$sliderParams[$key] = $param;
		}
		
		$width = intval($params->get('width', 300), 10);
		$height = intval($params->get('height'), 10);
		$isLiquidWidth = (strpos($params->get('width'), '%') !== false);
		
		if (empty($sliderParams['xPos']) && !$isLiquidWidth)
			$sliderParams['xPos'] = (int)($width / 2);
		
		if (empty($sliderParams['yPos']))
			$sliderParams['yPos'] = (int)($height / 3);
			
		if (empty($sliderParams['xRadius']) && !$isLiquidWidth)
			$sliderParams['xRadius'] = (int)($width / 2.3);
		
		if (empty($sliderParams['yRadius']))
			$sliderParams['yRadius'] = (int)($height / 6);
			
		return $sliderParams;
	}
	
	function getSlides($params)
	{
		$slides = array();

		$pathList = AriCloudCarouselHelper::getPathList($params->get('path'));
		if (count($pathList) == 0)
			return $slides;

		$extraFields = array();
		$i18n = (bool)$params->get('i18n', false);
		$descrFile = trim($params->get('descrFile', ''));
		$processDescrFile = !empty($descrFile);
		$processSubDir = (bool)$params->get('subdir');
		$imgNumber = intval($params->get('imgNumber', 0), 10);
		$images = array();
		$sort = AriCloudCarouselHelper::getSortExpr($params);
		foreach ($pathList as $path)
		{
			if (empty($path))
				continue ;
				
			if (@is_file($path))
			{
				$images[] = $path;
				$path = dirname($path);
			}
			else
			{
				$folderImages = AriFolder::files(
					$path,
					'.(jpg|gif|jpeg|png|bmp|JPG|GIF|JPEG|BMP|PNG)$', 
					$processSubDir,
					true,
					$sort);

				if (is_array($folderImages) && count($folderImages) > 0)
				{			
					if ($imgNumber > 0 && count($folderImages) > $imgNumber)
						$folderImages = array_slice($folderImages, 0, $imgNumber);

					$images = array_merge($images, $folderImages);
				}
			}

			if ($processDescrFile)
			{
				$folderExtraFields = AriAppUtils::getExtraFieldsFromINI($path, $descrFile, $processSubDir, true, $i18n);
				if (is_array($folderExtraFields) && count($folderExtraFields) > 0)
				{				
					$extraFields = array_merge($extraFields, $folderExtraFields);
				}
			}
		}

		$useThumbs = (bool)$params->get('imglist_useThumbs');
		$cachePath = $useThumbs ? AriCloudCarouselHelper::getCachePath() : null;
		$thumbPath = $params->get('imglist_thumbPath');
		$thumbWidth = intval($params->get('imglist_thumbWidth'), 10);
		$thumbHeight = intval($params->get('imglist_thumbHeight'), 10);
		$disableOriginal = (bool)$params->get('imglist_disableOriginal');
		foreach ($images as $image)
		{
			$slide = array(
				'src' => $image,
				'image' => str_replace('\\', '/', $image)
			);

			if ($processDescrFile)
			{
				if (isset($extraFields[$image]))
				{
					$slide = array_merge($extraFields[$image], $slide);
				}
				else
				{
					$cleanImage = str_replace('/', '\\', $image);
					if (isset($extraFields[$cleanImage]))
						$slide = array_merge($extraFields[$cleanImage], $slide);
				}
			} 
				
			if ($useThumbs)
				$slide = AriCloudCarouselHelper::generateThumbnail($slide, $thumbWidth, $thumbHeight, $thumbPath, $cachePath, $disableOriginal);

			$slides[] = $slide;
		}

		return $slides;
	}
	
	function generateThumbnail($slide, $thumbWidth, $thumbHeight, $thumbPath, $cachePath, $disableOriginal = false)
	{
		$img = $slide['src'];
		$imgUri = $slide['image'];
		$thumbFile = null;

		if ($thumbPath)
		{
			$pathInfo = pathinfo($img);
			$thumbImg = $pathInfo['dirname'] . DS .  str_replace(
				array('{$fileName}', '{$baseFileName}'), 
				array($pathInfo['basename'], basename($pathInfo['basename'], '.' . $pathInfo['extension'])), 
				$thumbPath);

			if (@file_exists(JPATH_ROOT . DS . $thumbImg) && @is_file(JPATH_ROOT . DS . $thumbImg))
			{
				$thumbFile = $thumbImg;
			}
		}

		if (is_null($thumbFile))
		{
			$thumbName = AriImageHelper::generateThumbnail(
				JPATH_ROOT . DS . $img, 
				JPATH_ROOT . DS . $cachePath, 
				'acc',
				$thumbWidth,
				$thumbHeight);
			if ($thumbName)
			{
				$thumbFile = $cachePath . DS . $thumbName;
			}
			else
			{
				$thumbFile = $img;
			}
		}

		$slide['src'] = $thumbFile;
		$slide['image'] = str_replace('\\', '/', $thumbFile);
		if (!$disableOriginal && empty($slide['link']))
			$slide['link'] = $imgUri;
			
		$thumbSize = AriImageHelper::getThumbnailDimension(JPATH_ROOT . DS . $thumbFile, $thumbWidth, $thumbHeight);
		if (!empty($thumbSize['w'])) $slide['width'] = $thumbSize['w'];
		if (!empty($thumbSize['h'])) $slide['height'] = $thumbSize['h'];
		
		return $slide;
	}
	
	function getCachePath()
	{
		$cacheDir = 'images';
		$extCacheDir = $cacheDir . DS . 'aricloudcarousel';
		if (@file_exists($extCacheDir) && is_dir($extCacheDir))
		{
			$cacheDir = $extCacheDir;
		}
		
		return $cacheDir;
	}
	
	function prepareSlides($slides, $params)
	{
		$newSlides = array();

		$target = $params->get('customLinkTarget');

		if (empty($target))
			
			$target = $params->get('linkTarget', '_self');

		$baseUri = JURI::base(true);
		$lightboxEngine = AriCloudCarouselHelper::getLightboxEngine($params);
		$lightboxGroup = uniqid('cc_');
		foreach ($slides as $slide)
		{
			$isLink = !empty($slide['link']);
			$description = isset($slide['description']) ? $slide['description'] : '';
			$title = isset($slide['title']) ? $slide['title'] : '';
		
			$lnkAttrs = null;
			$imgAttrs = array('src' => $baseUri . '/' . $slide['image'], 'alt' => $description, 'title' => $title, 'class' => 'cloudcarousel');
			if (!empty($slide['width'])) $imgAttrs['width'] = $slide['width'];
			if (!empty($slide['height'])) $imgAttrs['height'] = $slide['height'];
			if ($isLink)
			{
				$lnkAttrs = array('href' => $slide['link'], 'target' => $target);
				if ($description)
					$lnkAttrs['title'] = $description;
					
				if (!is_null($lightboxEngine))
					list($lnkAttrs, $imgAttrs) = $lightboxEngine->modifyAttrs($lnkAttrs, $imgAttrs, $lightboxGroup, $params);
				else
				{
					$originalLink = $slide['link'];
					if (strpos($originalLink, '_target') !== false)
					{
						$uri = new JURI($originalLink);
						$linkTarget = $uri->getVar('_target');
						if (!is_null($linkTarget))
						{
							$uri->delVar('_target');
							$lnkAttrs['target'] = $linkTarget;
							$lnkAttrs['href'] = $uri->toString();
						}
					}
				}
			}
					
			$slide['lnkAttrs'] = $lnkAttrs;
			$slide['imgAttrs'] = $imgAttrs;
			$newSlides[] = $slide;
		}
		
		return $newSlides;
	}
	
	function getSortExpr($params)
	{
		$sortBy = $params->get('sortBy');
		if (empty($sortBy) || !in_array($sortBy, array('filename', 'modified', 'random')))
			return null;
			
		return array(
			'sortBy' => $sortBy, 
			'sortDir' => ($params->get('sortDir') == 'desc' ? 'desc' : 'asc')
		);
	}
	
	function getPathList($path)
	{
		$pathList = array();
		if (empty($path))
			return $pathList;

		$pathList = explode("\n", $path);
		array_walk($pathList, array('AriFolder', 'clean'));
		$pathList = array_unique($pathList);
		
		return $pathList;
	}
	
	function getLightboxEngine($params)
	{
		$engine = null;
		$engineName = ucfirst(JFilterInput::clean($params->get('lightboxEngine'), 'WORD'));
		if (empty($engineName))
			return null;
		
		AriKernel::import('CloudCarousel.Lightbox.' . $engineName);
		
		$className = $engineName . 'CarouselEngine';
		if (class_exists($className))
		{
			$engine = new $className();
			if (!$engine->preCheck())
			{
				$engine = null;
			}
		}
		
		return $engine;
	}
}
?>