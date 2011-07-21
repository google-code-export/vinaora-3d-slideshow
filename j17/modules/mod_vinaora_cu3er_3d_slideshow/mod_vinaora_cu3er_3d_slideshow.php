<?php
/**
 * @version		$Id: mod_vinaora_cu3er_3d_slideshow.php 2011-07-20 vinaora $
 * @package		Vinaora Cu3er 3D Slideshow
 * @subpackage	mod_vinaora_cu3er_3d_slideshow
 * @copyright	Copyright (C) 2010 - 2011 VINAORA. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @website		http://vinaora.com
 * @twitter		http://twitter.com/vinaora
 * @facebook	http://facebook.com/vinaora
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';

$module_id = $module->id;

$config_custom		= $params->get( 'config_custom' );
$lastedit			= $params->get( 'lastedit' );
$config_name		= "V$module_id-$lastedit.xml";

$config_name		= ($lastedit) ? $config_name : "demo1.xml.php";
$config_name		= ($config_custom=="-1") ? $config_name : $config_custom;

$configHelper = new modVinaoraCu3er3DSlideshowHelper($params);

// Check Config file (.xml) exits and valid XML
$config_name = 'media/mod_vinaora_cu3er_3d_slideshow/config/'.$config_name;

$config = $configHelper->getConfig($config_name);

// Config File exist and valid
if ( $config ){
	$width  = $config->settings->general["slide_panel_width"];
	$height  = $config->settings->general["slide_panel_height"];
}
// Config File not exist
else{
	if($config_custom=="-1") $configHelper->createConfig($config_name);
}


$width  = (!empty($width)) ? $width : $params->get( 'slide_panel_width' );
$height = (!empty($height)) ? $height : $params->get( 'slide_panel_height' );

// Add SWFObject Library to <head> tag
$source = $params->get('swfobject_source', 'local');
$version = $params->get('swfobject_version', '2.2');
$flash_wmode = $params->get('flash_wmode');
modVinaoraCu3er3DSlideshowHelper::addSWFObject($source, $version);

// Initialize variables
$media					= JURI::base().'media/mod_vinaora_cu3er_3d_slideshow/';		// Use JURI::base() for Full URL
$config_name			= JURI::base().$config_name;
$slideshow_path 		= $media.'flash/cu3er.swf';
$expressInstall_path 	= $media.'js/swfobject/expressInstall.swf';
$flash_version			= '9.0.0';

$swffont				= $params->get('swffont');
$font_path				= ($swffont!= '-1') ? $media.'flash/fonts/'.$swffont : '';

$container				= 'vinaora-3d-slideshow'.$module_id;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_vinaora_cu3er_3d_slideshow', $params->get('layout', 'default'));
