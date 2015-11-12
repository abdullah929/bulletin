<?php

/**
 * @version		$Id$
 * @package		Joomla.Administrator
 * @subpackage	JoomDOC
 * @author      ARTIO s.r.o., info@artio.net, http:://www.artio.net
 * @copyright	Copyright (C) 2011 Artio s.r.o.. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* @var $this JoomDOCViewDocument */

JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

jimport('joomla.html.pagination');

$document = JFactory::getDocument();
/* @var $document JDocumentHTML */
$config = JoomDOCConfig::getInstance();
/* @var $config JoomDOCConfig */

$js[] = 'Joomla.submitbutton = function (task) {';
$js[] = '	var form = document.getElementById(\'item-form\');';
$js[] = '	if (task == \'' . JoomDOCHelper::getTask(JOOMDOC_DOCUMENT, JOOMDOC_TASK_CANCEL) . '\' || document.formvalidator.isValid(form)) {';
$js[] = '		Joomla.submitform(task, form);';
$js[] = '	} else {';
$js[] = '		alert(\'' . JText::_('JGLOBAL_VALIDATION_FORM_FAILED', true) . '\');';
$js[] = '	}';
$js[] = '}';
$js[] = 'function tableOrdering(order, dir, task) {';
$js[] = '	document.versionForm.filter_order.value = order;';
$js[] = '	document.versionForm.filter_order_Dir.value = dir;';
$js[] = '	document.versionForm.submit();';
$js[] = '}';
$js[] = 'function submitform(pressbutton) {';
$js[] = '	if (pressbutton) {';
$js[] = '		// toolbar work with document edit form';
$js[] = '		if (! Joomla.submitbutton(pressbutton)) {';
$js[] = '			return false;';
$js[] = '		}';
$js[] = '		// set task operation into hidden field task (save, apply, cancel etc.)';
$js[] = '		document.adminForm.task.value = pressbutton;';
$js[] = '	} else {';
$js[] = '		// others task are for version table';
$js[] = '		document.versionForm.submit();';
$js[] = '	}';
$js[] = '	if (typeof document.adminForm.onsubmit == "function") {';
$js[] = '		document.adminForm.onsubmit();';
$js[] = '	}';
$js[] = '	if (pressbutton) {';
$js[] = '		// toolbar work with document edit form';
$js[] = '		document.adminForm.submit();';
$js[] = '	}';
$js[] = '}';

$document->addScriptDeclaration(PHP_EOL . implode(PHP_EOL, $js) . PHP_EOL);

require_once JOOMDOC_ADMINISTRATOR . '/libraries/joomdoc/html/joomdoc.php';
echo JHtmlJoomDOC::startTabs('tabone', 'details');
echo JHtmlJoomDOC::addTab('JOOMDOC_DOCUMENT_DETAILS', 'details', 'tabone');

echo '<form action="' . JRoute::_(JoomDOCRoute::saveDocument($this->document->id)) . '" method="post" name="adminForm" id="item-form" class="form-validate">';
echo '<div class="fltlft col" style="width:60%">';
echo '<fieldset class="adminform">';
echo '<legend>' . JText::_('JOOMDOC_DOCUMENT') . '</legend>';
echo '<table class="admintable">';
echo '<tr><td class="key">' . $this->form->getLabel('title') . '</td>';
echo '<td>' . $this->form->getInput('title') . '</td></tr>';
echo '<tr><td class="key">' . $this->form->getLabel('alias') . '</td>';
echo '<td>' . $this->form->getInput('alias') . '</td></tr>';
echo '<tr><td class="key">' . $this->form->getLabel('state') . '</td>';
echo '<td>' . $this->form->getInput('state') . '</td></tr>';
echo '<tr><td class="key">' . $this->form->getLabel('favorite') . '</td>';
echo '<td>' . $this->form->getInput('favorite') . '</td></tr>';
echo '<tr><td class="key">' . $this->form->getLabel('access') . '</td>';
echo '<td>' . $this->form->getInput('access') . '</td></tr>';
if ($this->form->getField('download')) {
    echo '<tr><td class="key">' . $this->form->getLabel('download') . '</td>';
    echo '<td>' . $this->form->getInput('download') . '</td></tr>';
}
echo '<tr><td class="key">' . $this->form->getLabel('license') . '</td>';
echo '<td>' . $this->form->getInput('license') . '</td></tr>';

if (JoomDOCAccess::admin()) {
    echo '<!--';
    echo '<tr><td class="key"><span class="faux-label">' . JText::_('JGLOBAL_ACTION_PERMISSIONS_LABEL') . '</span>';
    echo '<div class="button2-left"><div class="blank">';
    echo '<button type="button" onclick="document.location.href=\'#access-rules\';">';
    echo JText::_('JGLOBAL_PERMISSIONS_ANCHOR');
    echo '</button>';
    echo '</div></div>';
    echo '</td></tr>';
    echo '-->';
}

echo '<tr><td class="key">' . $this->form->getLabel('id') . '</td>';
echo '<td>' . $this->form->getInput('id') . '</td></tr>';
echo '<tr><td class="key">' . $this->form->getLabel('path') . '</td>';
echo '<td>';
echo '<span class="input-append">';
echo $this->form->getInput('path');
echo '<button onclick="return JoomDOC.copyPath(\'' . $this->escape(JFile::getName($this->form->getValue('path'))) . '\')" title="' . $this->escape(JText::_('JOOMDOC_COPY_DESC')) . '" class="btn">';
echo '<span class="icon-copy"></span>';
echo JText::_('JOOMDOC_COPY');
echo '</button>';
echo '</span>';
echo '</td></tr>';

// custom fields
$fields = $this->form->getFieldset();
foreach ($fields as $field) {
	/* @var $field JFormField */
	$fieldname = $field->__get('fieldname');
	if (JString::strpos($fieldname, 'field') === 0) {
		echo '<tr><td class="key">' . $this->form->getLabel($fieldname) . '</td>';
		echo '<td>' . $this->form->getInput($fieldname) . '</td></tr>';
	}
}

echo '</table>';
echo '<div class="clr"></div>';
echo $this->form->getLabel('description');
echo '<div class="clr"></div>';
echo $this->form->getInput('description');
echo '</fieldset>';
echo '<div class="clr"></div>';
echo '</div>';
echo '<div class="fltlft col" style="width:40%">';

echo JHtmlJoomDOC::startSliders('content-sliders-' . $this->document->id, 'publishing-details');
echo JHtmlJoomDOC::addSlide('content-sliders-' . $this->document->id, 'JOOMDOC_PUBLISHING', 'publishing-details');

echo '<fieldset class="panelform">';
echo '<table class="admintable">';
echo '<tr><td class="key">' . $this->form->getLabel('created_by') . '</td>';
echo '<td>' . $this->form->getInput('created_by') . '</td></tr>';
echo '<tr><td class="key">' . $this->form->getLabel('created') . '</td>';
echo '<td>' . $this->date('created') . '</td></tr>';
echo '<tr><td class="key">' . $this->form->getLabel('publish_up') . '</td>';
echo '<td>' . $this->date('publish_up') . '</td></tr>';
echo '<tr><td class="key">' . $this->form->getLabel('publish_down') . '</td>';
echo '<td>' . $this->date('publish_down') . '</td></tr>';
if ($this->document->modified_by) {
    echo '<tr><td class="key">' . $this->form->getLabel('modified_by') . '</td>';
    echo '<td>' . $this->form->getInput('modified_by') . '</td></tr>';
    echo '<tr><td class="key">' . $this->form->getLabel('modified') . '</td>';
    echo '<td>' . $this->date('modified') . '</td></tr>';
}
echo '</table>';
echo '</fieldset>';

echo JHtmlJoomDOC::endSlide();


$fieldSets = $this->form->getFieldsets('params');
foreach ($fieldSets as $name => $fieldSet) {
	
	echo JHtmlJoomDOC::addSlide('content-sliders-' . $this->document->id, $fieldSet->label, $name . '-options');

    if (isset($fieldSet->description) && ($desc = JString::trim($fieldSet->description))) {
        echo '<p class="tip">' . $this->escape(JText::_($desc)) . '</p>';
    }
    echo '<fieldset class="panelform"><table class="admintable">';
    foreach ($this->form->getFieldset($name) as $field) {
        echo '<tr><td class="key">' . $field->label . '</td><td>' . $field->input . '</td></tr>';
    }
    echo '</table></fieldset>';
    
    echo JHtmlJoomDOC::endSlide();
}

echo JHtmlJoomDOC::endSlides();

echo '</div>';
echo '<div class="clr"></div>';
if (JoomDOCAccess::admin()) {
    //echo '<div class="width-100 fltlft">';
    echo '<div class="fltlft col">';
    
    echo JHtmlJoomDOC::startSliders('permissions-sliders-' . $this->document->id, 'access-rules');
    echo JHtmlJoomDOC::addSlide('permissions-sliders-' . $this->document->id, 'JOOMDOC_FIELDSET_RULES', 'access-rules');
    
    echo '<fieldset class="panelform">';
    echo $this->form->getLabel('rules');
    echo $this->form->getInput('rules');
    echo '</fieldset>';
    
    echo JHtmlJoomDOC::endSlide();
    echo JHtmlJoomDOC::endSlides();
    
    echo '</div>';
}
echo '<div>';
echo '<input type="hidden" name="task" value="" />';
echo '<input type="hidden" name="return" value="' . JRequest::getCmd('return') . '" />';
echo JHtml::_('form.token');
echo '</div>';
echo '</form>';

echo JHtmlJoomDOC::endTab();
echo JHtmlJoomDOC::endTabs();

?>