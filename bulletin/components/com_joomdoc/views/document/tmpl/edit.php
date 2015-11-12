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

JHtmlBehavior::tooltip();
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

jimport('joomla.html.pagination');

$mainframe = JFactory::getApplication();
$document = JFactory::getDocument();
/* @var $mainframe JApplication */
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

echo '<div id="document">';
echo '<div class="edittoolbar">';

if ($this->access->canCreate || $this->access->canEdit) {
    echo '<a href="javascript:Joomla.submitbutton(\'' . JoomDOCHelper::getTask(JOOMDOC_DOCUMENT, JOOMDOC_TASK_APPLY) . '\')" class="apply" title="">' . JText::_('JTOOLBAR_APPLY') . '</a>';
    echo '<a href="javascript:Joomla.submitbutton(\'' . JoomDOCHelper::getTask(JOOMDOC_DOCUMENT, JOOMDOC_TASK_SAVE) . '\')" class="save" title="">' . JText::_('JTOOLBAR_SAVE') . '</a>';
}
echo '<a href="javascript:Joomla.submitbutton(\'' . JoomDOCHelper::getTask(JOOMDOC_DOCUMENT, JOOMDOC_TASK_CANCEL) . '\')" class="cancel" title="">' . JText::_('JTOOLBAR_CANCEL') . '</a>';

echo '<div class="clr"></div>';
echo '</div>';

require_once JOOMDOC_ADMINISTRATOR . '/libraries/joomdoc/html/joomdoc.php';
echo JHtmlJoomDOC::startTabs('tabone', 'details');
echo JHtmlJoomDOC::addTab('JOOMDOC_DOCUMENT_DETAILS', 'details', 'tabone');

echo '<script type="text/javascript">';
echo '//<![CDATA[';
/**
 * Joomla 1.6.x
 */
echo 'Joomla.submitbutton = function(task) {';
echo 'if (task == \'' . JoomDOCHelper::getTask(JOOMDOC_DOCUMENT, JOOMDOC_TASK_CANCEL) . '\' || document.formvalidator.isValid(document.getElementById(\'item-form\'))) {';
echo 'try {';
echo 'Joomla.submitform(task, document.getElementById(\'item-form\'));';
echo '} catch(e) {';
echo 'document.adminForm.task.value = task;';
echo 'document.adminForm.submit();';
echo '}';
echo '} else {';
echo 'alert(\'' . JText::_('JGLOBAL_VALIDATION_FORM_FAILED', true) . '\');';
echo '}';
echo '}';
/**
 * Submit form operation.
 *
 * @param pressbutton taks value from toolbar button
 */
echo 'function submitform(pressbutton) {';
echo 'if (pressbutton) {';
// toolbar work with document edit form
echo 'if (! Joomla.submitbutton(pressbutton)) {';
echo 'return false;';
echo '}';
// set task operation into hidden field task (save, apply, cancel etc.)
echo 'document.adminForm.task.value = pressbutton;';
echo '}';
echo 'if (typeof document.adminForm.onsubmit == "function") {';
echo 'document.adminForm.onsubmit();';
echo '}';
echo 'if (pressbutton) {';
// toolbar work with document edit form
echo 'document.adminForm.submit();';
echo '}';
echo '}';
echo '//]]>';
echo '</script>';

echo '<form action="index.php" method="post" name="adminForm" id="item-form" class="form-validate">';
echo '<div>';
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

echo '<tr><td class="key">' . $this->form->getLabel('id') . '</td>';
echo '<td>' . $this->form->getInput('id') . '</td></tr>';

echo '<tr><td class="key">' . $this->form->getLabel('path') . '</td>';
echo '<td>';
echo $this->form->getInput('path');
echo '<button onclick="return JoomDOC.copyPath(\'' . $this->escape(JFile::getName($this->form->getValue('path'))) . '\')" title="' . $this->escape(JText::_('JOOMDOC_COPY_DESC')) . '">' . JText::_('JOOMDOC_COPY') . '</button>';
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

echo '<tr><td class="key" colspan="2">' . $this->form->getLabel('description') . '</td></tr>';
echo '</table>';
echo '<div>' . $this->form->getInput('description') . '</div>';
echo '</fieldset>';
echo '<div class="clr"></div>';
echo '</div>';

echo '<div>';


echo JHtmlJoomDOC::startSliders('content-sliders-' . $this->document->id,'publishing-details');
echo JHtmlJoomDOC::addSlide('content-sliders-' . $this->document->id, 'JOOMDOC_PUBLISHING', 'publishing-details');

echo '<fieldset class="panelform">';
echo '<table class="admintable">';
$creatorID = $this->form->getValue('created_by');
if ($creatorID) {
    $creator = JFactory::getUser($creatorID);
    /* @var $creator JUser */
    if ($creator->id) {
        echo '<tr><td class="key">' . $this->form->getLabel('created_by') . '</td>';
        echo '<td>' . $creator->name . '</td></tr>';
    }
}
if ($this->document->created) {
    echo '<tr><td class="key">' . $this->form->getLabel('created') . '</td>';
    echo '<td>' . JHtml::date($this->form->getValue('created'), JText::_('DATE_FORMAT_LC2')) . '</td></tr>';
}
$modifierID = $this->form->getValue('modified_by');
if ($modifierID) {
    $modifier = JFactory::getUser($modifierID);
    /* @var $modifier JUser */
    if ($modifier->id) {
        echo '<tr><td class="key">' . $this->form->getLabel('modified_by') . '</td>';
        echo '<td>' . $modifier->name . '</td></tr>';
    }
}

if (JoomDOCHelper::canViewModified($this->document->created, $this->document->modified)) {
    echo '<tr><td class="key">' . $this->form->getLabel('modified') . '</td>';
    echo '<td>' . JHtml::date($this->form->getValue('modified'), JText::_('DATE_FORMAT_LC2')) . '</td></tr>';
}
if ($this->access->canEditState) {
    echo '<tr><td class="key">' . $this->form->getLabel('publish_up') . '</td><td>' . $this->date('publish_up') . '</td></tr>';
    echo '<tr><td class="key">' . $this->form->getLabel('publish_down') . '</td><td>' . $this->date('publish_down') . '</td></tr>';
}
echo '</table>';
echo '</fieldset>';

echo JHtmlJoomDOC::endSlide();

foreach ($this->form->getFieldsets('params') as $name => $fieldSet) {

	echo JHtmlJoomDOC::addSlide('content-sliders-' . $this->document->id,$fieldSet->label, $name . '-options');

    if (isset($fieldSet->description) && JString::trim($fieldSet->description)) {
        echo '<p class="tip">' . $this->escape(JText::_($fieldSet->description)) . '</p>';
    }
    echo '<fieldset class="panelform">';
    echo '<table class="admintable">';
    foreach ($this->form->getFieldset($name) as $field) {
        echo '<tr>';
        echo '<td class="key">' . $field->label . '</td>';
        echo '<td>' . $field->input . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</fieldset>';

    echo JHtmlJoomDOC::endSlide();
}

echo JHtmlJoomDOC::endSlides();

echo '</div>';
echo '<div class="clr"></div>';

if (JoomDOCAccess::admin()) {
    echo '<div>';
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
echo '<input type="hidden" name="Itemid" value="' . JoomDOCMenu::getMenuItemID($this->form->getValue('path')) . '" />';
echo '<input type="hidden" name="task" value="" />';
echo '<input type="hidden" name="id" value="' . $this->document->id . '" />';
echo '<input type="hidden" name="option" value="' . JOOMDOC_OPTION . '" />';
echo '<input type="hidden" name="return" value="' . JRequest::getCmd('return') . '" />';
echo JHtml::_('form.token');
echo '</div>';
echo '</form>';

echo JHtmlJoomDOC::endTab();
echo JHtmlJoomDOC::endTabs();
echo '</div>';
?>