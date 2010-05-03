<?php
/**
* @version		$Id: lastedit.php 2010-04-30 vinaora $
* @package		VINAORA CU3ER 3D SLIDESHOW
* @copyright	Copyright (C) 2010 VINAORA and CU3ER. All rights reserved.
* @license		GNU/GPL
* @website		http://vinaora.com
* @email		admin@vinaora.com
* 
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class JElementLastEdit extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'LastEdit';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$size = ( $node->attributes('size') ? 'size="'.$node->attributes('size').'"' : '' );
		$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="text_area"' );
        /*
         * Required to avoid a cycle of encoding &
         * html_entity_decode was used in place of htmlspecialchars_decode because
         * htmlspecialchars_decode is not compatible with PHP 4
         */
        $value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES), ENT_QUOTES);
		
		$config = & JFactory::getConfig();
		$offset	= $config->getValue('config.offset');
		
		$now = & JFactory::getDate();
		$now->setOffset($offset);
		
		$value		= $now->toFormat('%Y%m%d_%H%M%S');
		
		$cid		= JRequest::getVar('cid');
		$module_id	= $cid[0];
		
		$module_id	= $module_id ? $module_id : JRequest::getVar('id');
		
		$value		= "V".$module_id.'_'.$value.'.xml';
		
		return '<input type="hidden" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" '.$class.' '.$size.' />';
	}
	
	function fetchTooltip($label, $description, &$xmlElement, $control_name='', $name='') {
		return false;
	}
}
