<?php
/**
* Module Joomla! 3.0 Native Component
* @version 1.0
* @author Noah Nguyen
* @link http://melbournedesigncup.com/
* @license GNU/GPL */
?>
<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
 
<?php if($showTime == '1'){?>
<h4> Time :  <?php echo $exmm[2]; ?></h4>
<?php } ?>

<?php if($showDate =='1'){ ?>
<h4> Date :  <?php echo $exmm[1]; ?></h4>
<?php } ?>

<?php if($showDay =='1'){ ?>
<h4> Day :  <?php echo $exmm[3]; ?></h4>
<?php } ?>

<?php echo '<p class="melblink" style="display: none;">DT by <a rel="nofollow" title="enter logic seo" href="http://enter-logic-seo.gr/">enter-logic-seo.gr</a></p>';?>