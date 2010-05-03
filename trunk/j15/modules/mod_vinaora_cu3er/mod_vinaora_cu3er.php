<?php
/**
* @version		$Id: mod_vinaora_cu3er.php 2010-04-30 vinaora $
* @package		VINAORA CU3ER 3D SLIDESHOW
* @copyright	Copyright (C) 2010 VINAORA and CU3ER. All rights reserved.
* @license		GNU/GPL
* @website		http://vinaora.com
* @email		admin@vinaora.com
* 
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Require Base Helper
require_once dirname(__FILE__).DS.'helper.php';

// Choose images/slides from a directory
$directory = $params->get('slide_dir');

// Overwrite 'slide_url' parameter
if ( $directory != -1 ){
	$images = modVinaoraCu3erHelper::getImageURLs($directory);
	$images_param = implode("\n", $images);
	$params->set('slide_url', $images_param);
}

$config_dir 		= JPATH_BASE.DS.'media'.DS.'mod_vinaora_cu3er'.DS.'config';

$config_custom		= $params->get( 'config_custom' );
$config_name 		= $params->get( 'config_code' );

$config_name		= ($config_name) ? $config_name : "demo1.xml.php";
$config_name		= ($config_custom=="-1") ? $config_name : $config_custom;

// Check Config file (.xml) exits and valid XML
$config = modVinaoraCu3erHelper::getConfig($config_dir, $config_name);

// Config File exist and valid
if ( $config ){
	$width	= modVinaoraCu3erHelper::getAttributes($config, 'settings/general', 'slide_panel_width');
	$height	= modVinaoraCu3erHelper::getAttributes($config, 'settings/general', 'slide_panel_height');
}
// Config File not exist
else{
	$xml = modVinaoraCu3erHelper::createXML($params);
	modVinaoraCu3erHelper::createConfig($config_dir, $config_name, $xml);
}

$width	= (!empty($width)) ? $width : $params->get( 'slide_panel_width' );
$height	= (!empty($height)) ? $height : $params->get( 'slide_panel_height' );

// Add SWFObject Library to <head> tag
modVinaoraCu3erHelper::addSWFObject( $params->get('swfobject') );

// Initialize variables
$media					= JURI::base().'media/mod_vinaora_cu3er/';		// Use JURI::base() for Full URL
$config_path 			= $media.'config/'.$config_name;
$slideshow_path 		= $media.'flash/cu3er.swf';
$expressInstall_path 	= $media.'js/swfobject/expressInstall.swf';
$flash_version			= '9';

$swffont				= $params->get('swffont');
$font_path				= ($swffont!= '-1') ? $media.'flash/fonts/'.$swffont : '';

$moduleclass_sfx		= trim( $params->get( 'moduleclass_sfx' ) );

$module_id				= $module->id;
$container				= 'vinaora-3d-slideshow'.$module_id;

// Add Custom CSS to <head> tag
$document =& JFactory::getDocument();

$css= "\n\t".'<style type="text/css">'
	. "\n\t".'#'.$container.' {width:'.$width.'px; outline:0;}'
	. "\n  ".'</style>';
	
$document->addCustomTag($css);

// Load Default Layout
require(JModuleHelper::getLayoutPath('mod_vinaora_cu3er'));
