<?php
/*
 * ARI Framework Lite
 *
 * @package		ARI Framework Lite
 * @version		1.0.0
 * @author		ARI Soft
 * @copyright	Copyright (c) 2009 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

defined('_JEXEC') or die('Restricted access');

if (!defined('J3_2'))
{
	$version = new JVersion();
	define('J3_2', version_compare($version->getShortVersion(), '3.2.0', '>='));
}

jimport('joomla.filesystem.folder');

class mod_aricloudcarouselInstallerScript
{
	function preflight($type, $parent)
	{
		$type = strtolower($type);
		if ($type == 'install' || $type == 'update')
			$this->updateManifest($parent);
	}

	function postflight($type, $parent)
	{
		$type = strtolower($type);
		if ($type == 'install' || $type == 'update')
		{
			$this->createFolders();

			if (J3_2)
				$this->removeOutdateFiles();
		}

	}

	private function createFolders()
	{
		$thumbFolder = JPATH_ROOT . '/images/aricloudcarousel';

		if (!JFolder::exists($thumbFolder))
			JFolder::create($thumbFolder);
	}
	
	private function updateManifest($parent)
	{
		jimport('joomla.filesystem.file');
		
		$installer = $parent->getParent();
		$manifestFile = basename($installer->getPath('manifest'));
		$cleanManifestFile = preg_replace('/^\_+/i', '', $manifestFile);

		$dir = dirname(__FILE__) . '/install/';

		JFile::delete($dir . $cleanManifestFile);
		JFile::copy($dir . '../' . $cleanManifestFile, $dir . $cleanManifestFile);
	}

	private function removeOutdateFiles()
	{
		jimport('joomla.filesystem.file');

		$colorFieldFile = JPATH_ROOT . '/modules/mod_aricloudcarousel/mod_aricloudcarousel/fields/color.php';
		if (file_exists($colorFieldFile))
			JFile::delete($colorFieldFile);

		$colorFolder = JPATH_ROOT . '/modules/mod_aricloudcarousel/mod_aricloudcarousel/fields/color';

		if (file_exists($colorFolder))
			JFolder::delete($colorFolder);
	}
}