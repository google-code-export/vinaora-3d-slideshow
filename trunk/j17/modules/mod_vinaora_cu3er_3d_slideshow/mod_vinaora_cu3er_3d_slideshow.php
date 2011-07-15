<?php
/**
 * @version		:  2011-07-13 02:07:11$
 * @author		 
 * @package		Abcdef
 * @copyright	Copyright (C) 2011- . All rights reserved.
 * @license		
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';


$config_custom		= $params->get( 'config_custom' );
$config_name		= $params->get( 'config_code' );

$config_name		= ($config_name) ? $config_name : "demo1.xml.php";
$config_name		= ($config_custom=="-1") ? $config_name : $config_custom;

$configHelper = new modVinaoraCu3er3DSlideshowHelper($params);

// Check Config file (.xml) exits and valid XML
$config_name = 'media/mod_vinaora_cu3er_3d_slideshow/config/'.$config_name;
$config = $configHelper->getConfig($config_name);

// Config File exist and valid
if ( $config ){
	$width  = $config->settings->general["slide_panel_width"]);
	$height  = $config->settings->general["slide_panel_height"]);
	
}
// Config File not exist
else{
	$configHelper->createConfig($config_name);
}

$width  = (!empty($width)) ? $width : $params->get( 'slide_panel_width' );
$height = (!empty($height)) ? $height : $params->get( 'slide_panel_height' );

// Add SWFObject Library to <head> tag
modVinaoraCu3er3DSlideshowHelper::addSWFObject( $params->get('swfobject') );

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_vinaora_cu3er_3d_slideshow', $params->get('layout', 'default'));