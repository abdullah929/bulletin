<?php
/*
 * ARI Cloud Carousel Joomla! module
 *
 * @package		ARI Cloud Carousel Joomla! module.
 * @version		1.0.0
 * @author		ARI Soft
 * @copyright	Copyright (c) 2009 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

$cssClass = $params->get('cssClass');
$lblLeft = $params->get('lbl_left');
$lblRight = $params->get('lbl_right');
$showNav = (bool)$params->get('showNav');
$showTitle = (bool)$params->get('showTitle');
$showAlt = (bool)$params->get('showAlt');
$headerText = $params->get('beforeText');
$footerText = $params->get('afterText');
?>
<?php
	if ($headerText): 
?>
<div id="<?php echo $carouselId; ?>_header" class="ari-cloud-carousel-header">
	<?php echo $headerText; ?>
</div>
<?php 
	endif;
?>
<div id="<?php echo $carouselId; ?>_wrapper" class="ari-cloud-carousel-loading ari-cloud-carousel-wrapper<?php if ($cssClass):?> <?php echo $cssClass; ?><?php endif; ?>">
	<div class="ari-cloud-carousel-caption">
		<?php
			if ($showTitle):
		?>
		<div class="ari-cloud-carousel-title"></div>
		<?php
			endif; 
		?>
		<?php
			if ($showAlt):
		?>
		<div class="ari-cloud-carousel-alt"></div>
		<?php
			endif; 
		?>
	</div>
	<div id="<?php echo $carouselId; ?>" class="ari-cloud-carousel">
	<?php
	foreach ($slides as $slide):
		$isLink = !empty($slide['link']);
	?>
		<?php
			if ($isLink):
		?>
			<a<?php echo AriHtmlHelper::getAttrStr($slide['lnkAttrs']); ?>>
		<?php
			endif;
		?>
		<img<?php echo AriHtmlHelper::getAttrStr($slide['imgAttrs']); ?> />
		<?php
			if ($isLink):
		?>
			</a>
		<?php
			endif; 
		?>
	<?php
	endforeach;
	?>
	</div>
	<?php
		if ($showNav):
	?>
	<div class="ari-cloud-carousel-nav">
		<a href="#" class="ari-cloud-carousel-left" onclick="return false;" onfocus="this.blur(); return false;" title="<?php echo addcslashes($lblLeft, '"'); ?>"><?php echo $lblLeft; ?></a>
		<a href="#" class="ari-cloud-carousel-right" onclick="return false;" onfocus="this.blur(); return false;" title="<?php echo addcslashes($lblRight, '"'); ?>"><?php echo $lblRight; ?></a>
	</div>
	<?php
		endif;
	?>
</div>
<?php
	if ($footerText): 
?>
<div id="<?php echo $carouselId; ?>_footer" class="ari-cloud-carousel-footer">
	<?php echo $footerText; ?>
</div>
<?php 
	endif;
?>