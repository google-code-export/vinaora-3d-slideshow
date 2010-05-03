<?php
/**
* @version		$Id: helper.php 2010-04-30 vinaora $
* @package		VINAORA CU3ER 3D SLIDESHOW
* @copyright	Copyright (C) 2010 VINAORA and CU3ER. All rights reserved.
* @license		GNU/GPL
* @website		http://vinaora.com
* @email		admin@vinaora.com
* 
*/

// no direct accessd
defined( '_JEXEC' ) or die( 'Restricted access' );

class modVinaoraCu3erHelper
{
	/*
	 * Get content of the config file
	 */
	function getConfig($path, $name="config.xml"){

		$path = JPath::clean($path);

		if (file_exists($path.DS.$name)){
			$xml =& JFactory::getXMLParser( 'simple' );
			$xml->loadFile($path.DS.$name);
			//TODO File exits but not valid XML
			
			return $xml;
		}
		else{
			//TODO File not exits
		}

		return NULL;

	}

	/*
	 * Create the config file
	 */
	function createConfig($path, $name="config.xml", $xml){

		jimport('joomla.filesystem.file');
		$path = JPath::clean($path);

		if (is_writeable($path)){
			if ( JFile::write($path.DS.$name, $xml) ) return true;
			else{
				// TODO: Write file error
			}
		}
		else{
			// TODO: Folder is not writeable
		}

		return false;

	}

	/*
	 * Create content of the config file
	 */
	function createXML($params){

		// Create Element - <cu3er>
		$node = new JSimpleXMLElement('cu3er');

		// Create Element - <cu3er>.<settings>
		$nodeL1 = & $node->addChild('settings');

		// Create Element - <cu3er>.<settings>.<general>
		$nodeL2 = & modVinaoraCu3erHelper::createGeneral($nodeL1, $params);

		// Create Element - <cu3er>.<settings>.<debug>
		if ($params->get('enable_debug')){
			$nodeL2 = & modVinaoraCu3erHelper::createDebug($nodeL1, $params);
		}

		// Create Element - <cu3er>.<settings>.<auto_play>
		if ($params->get('enable_auto_play')){
			$nodeL2 = & modVinaoraCu3erHelper::createAutoPlay($nodeL1, $params);
		}

		// Create Element - <cu3er>.<settings>.<pre_button>
		if ($params->get('enable_prev_button')){
			$nodeL2 = & modVinaoraCu3erHelper::createPreviousButton($nodeL1, $params);
		}

		// Create Element - <cu3er>.<settings>.<pre_symbol>
		if ($params->get('enable_prev_symbol')){
			$nodeL2 = & modVinaoraCu3erHelper::createPreviousSymbol($nodeL1, $params);
		}

		// Create Element - <cu3er>.<settings>.<next_button>
		if ($params->get('enable_next_button')){
			$nodeL2 = & modVinaoraCu3erHelper::createNextButton($nodeL1, $params);
		}

		// Create Element - <cu3er>.<settings>.<next_symbol>
		if ($params->get('enable_next_symbol')){
			$nodeL2 = & modVinaoraCu3erHelper::createNextSymbol($nodeL1, $params);
		}

		// Create Element - <cu3er>.<settings>.<preloader>
		if ($params->get('enable_preloader')){
			$nodeL2 = & modVinaoraCu3erHelper::createPreloader($nodeL1, $params);
		}

		// Create Element - <cu3er>.<settings>.<description>
		if ($params->get('enable_description_box')){
			$nodeL2 = & modVinaoraCu3erHelper::createDescriptionBox($nodeL1, $params);
		}

		// Create Element - <cu3er>.<settings>.<transitions>
		if ($params->get('transition_type') == 'first'){
			$nodeL2 = & modVinaoraCu3erHelper::createTransitions($nodeL1, $params);
		}

		// Create Element - <cu3er>.<slides>
		$nodeL2 = & modVinaoraCu3erHelper::createSlides($node, $params);

		$string = '<?xml version="1.0" encoding="utf-8"?>';
		$string .= $node->toString(true);
		
		modVinaoraCu3erHelper::replaceTweenName($string);

		return $string;
	}

	/*
	 * Create General Settings
	 */
	function &createGeneral(&$node, $params){

		$general = array();
		$general["slide_panel_width"] 				= (int) $params->get('slide_panel_width');
		$general["slide_panel_height"] 				= (int) $params->get('slide_panel_height');
		$general["slide_panel_horizontal_align"] 	= (string) $params->get('slide_panel_horizontal_align');
		$general["slide_panel_vertical_align"] 		= (string) $params->get('slide_panel_vertical_align');
		$general["ui_visibility_time"] 				= (int) $params->get('ui_visibility_time');

		// Create Element - <cu3er>.<settings>.<general>
		$nodeL1 = & $node->addChild('general');

		// Crate Attribs of <cu3er>.<settings>.<general>
		modVinaoraCu3erHelper::addAttributes($nodeL1, $general);

		return $node;
	}

	/*
	 * Create Debug Settings
	 */
	function &createDebug(&$node, $params){

		$debug = array();
		$debug["x"]	= (int) $params->get('debug_x');
		$debug["y"]	= (int) $params->get('debug_y');

		// Create Element - <cu3er>.<settings>.<debug>
		$nodeL1 = & $node->addChild('debug');

		// Crate Attribs of <cu3er>.<settings>.<debug>
		modVinaoraCu3erHelper::addAttributes($nodeL1, $debug);

		return $node;
	}

	/*
	 * Create Auto-Play Settings
	 */
	function &createAutoPlay(&$node, $params){

		$childnaname = array("defaults", "tweenIn", "tweenOut", "tweenOver");
		$name = 'auto_play';

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"symbol"	=> $params->get('auto_play_symbol', 'linear'),
				"time"		=> $params->get('auto_play_time_defaults', 5)
			);
		$attbs["tweenIn"] = & modVinaoraCu3erHelper::getTweenArray($params, 'in', $name);
		$attbs["tweenOut"] = & modVinaoraCu3erHelper::getTweenArray($params, 'out', $name);
		$attbs["tweenOver"] = & modVinaoraCu3erHelper::getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<auto_play>
		$nodeL1 = modVinaoraCu3erHelper::createButton($node, $name, $childnaname, $attbs);

		return $node;
	}

	/*
	 * Create Previous Button Settings
	 */
	function &createPreviousButton(&$node, $params){

		$childnaname = array("defaults", "tweenIn", "tweenOut", "tweenOver");
		$name = 'prev_button';

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"round_corners" => $params->get('prev_button_round_corners', '0, 0, 0, 0')
			);
		$attbs["tweenIn"] = & modVinaoraCu3erHelper::getTweenArray($params, 'in', $name);
		$attbs["tweenOut"] = & modVinaoraCu3erHelper::getTweenArray($params, 'out', $name);
		$attbs["tweenOver"] = & modVinaoraCu3erHelper::getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<prev_button>
		$nodeL1 = modVinaoraCu3erHelper::createButton($node, $name, $childnaname, $attbs);

		return $node;
	}

	/*
	 * Create Previous Symbol Settings
	 */
	function &createPreviousSymbol(&$node, $params){

		$childnaname = array("defaults", "tweenIn", "tweenOut", "tweenOver");
		$name = 'prev_symbol';

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"type" => $params->get('prev_symbol_type', '1')
			);
		$attbs["tweenIn"] = & modVinaoraCu3erHelper::getTweenArray($params, 'in', $name);
		$attbs["tweenOut"] = & modVinaoraCu3erHelper::getTweenArray($params, 'out', $name);
		$attbs["tweenOver"] = & modVinaoraCu3erHelper::getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<prev_symbol>
		$nodeL1 = modVinaoraCu3erHelper::createButton($node, $name, $childnaname, $attbs);

		return $node;
	}

	/*
	 * Create Next Button Settings
	 */
	function &createNextButton(&$node, $params){

		$childnaname = array("defaults", "tweenIn", "tweenOut", "tweenOver");
		$name = 'next_button';

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"round_corners" => $params->get('next_button_round_corners', '0, 0, 0, 0')
			);
		$attbs["tweenIn"] = & modVinaoraCu3erHelper::getTweenArray($params, 'in', $name);
		$attbs["tweenOut"] = & modVinaoraCu3erHelper::getTweenArray($params, 'out', $name);
		$attbs["tweenOver"] = & modVinaoraCu3erHelper::getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<next_button>
		$nodeL1 = modVinaoraCu3erHelper::createButton($node, $name, $childnaname, $attbs);

		return $node;
	}

	/*
	 * Create Next Symbol Settings
	 */
	function &createNextSymbol(&$node, $params){

		$childnaname = array("defaults", "tweenIn", "tweenOut", "tweenOver");
		$name = 'next_symbol';

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"type" => $params->get('next_symbol_type', '1')
			);
		$attbs["tweenIn"] = & modVinaoraCu3erHelper::getTweenArray($params, 'in', $name);
		$attbs["tweenOut"] = & modVinaoraCu3erHelper::getTweenArray($params, 'out', $name);
		$attbs["tweenOver"] = & modVinaoraCu3erHelper::getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<next_symbol>
		$nodeL1 = modVinaoraCu3erHelper::createButton($node, $name, $childnaname, $attbs);

		return $node;
	}

	/*
	 * Create Preloader Settings
	 */
	function &createPreloader(&$node, $params){

		$childnaname = array("defaults", "tweenIn", "tweenOut");
		$name = 'preloader';

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"symbol" => $params->get('preloader_symbol', 'linear')
			);
		$attbs["tweenIn"] = & modVinaoraCu3erHelper::getTweenArray($params, 'in', $name);
		$attbs["tweenOut"] = & modVinaoraCu3erHelper::getTweenArray($params, 'out', $name);

		// Create Element - <cu3er>.<settings>.<preloader>
		$nodeL1 = modVinaoraCu3erHelper::createButton($node, $name, $childnaname, $attbs);

		return $node;
	}

	/*
	 * Create Description Box Settings
	 */
	function &createDescriptionBox(&$node, $params){

		$childnaname = array("defaults", "tweenIn", "tweenOut", "tweenOver");
		$name = 'description';

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"round_corners" 				=> $params->get('description_round_corners', '0, 0, 0, 0'),
				"heading_font" 					=> $params->get('description_heading_font', 'Georgia'),
				"heading_text_size" 			=> $params->get('description_heading_text_size', '18'),
				"heading_text_color" 			=> $params->get('description_heading_text_color', '0x000000'),
				"heading_text_align" 			=> $params->get('description_heading_text_align', 'left'),
				"heading_text_margin" 			=> $params->get('description_heading_text_margin', '10, 25, 0, 25'),
				"heading_text_leading" 			=> $params->get('description_heading_text_leading', '0'),
				"heading_text_letterSpacing"	=> $params->get('description_heading_text_letterSpacing', '0'),
				"paragraph_font" 				=> $params->get('description_paragraph_font', 'Arial'),
				"paragraph_text_size" 			=> $params->get('description_paragraph_text_size', '12'),
				"paragraph_text_color" 			=> $params->get('description_paragraph_text_color', '0x000000'),
				"paragraph_text_align" 			=> $params->get('description_paragraph_text_align', 'left'),
				"paragraph_text_margin" 		=> $params->get('description_paragraph_text_margin', '5, 25, 0, 25'),
				"paragraph_text_leading" 		=> $params->get('description_paragraph_text_leading', '0'),
				"paragraph_text_letterSpacing" 	=> $params->get('description_paragraph_text_letterSpacing', '0')
			);
		$attbs["tweenIn"] = & modVinaoraCu3erHelper::getTweenArray($params, 'in', $name);
		$attbs["tweenOut"] = & modVinaoraCu3erHelper::getTweenArray($params, 'out', $name);
		$attbs["tweenOver"] = & modVinaoraCu3erHelper::getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<description>
		$nodeL1 = modVinaoraCu3erHelper::createButton($node, $name, $childnaname, $attbs);

		return $node;
	}

	/*
	 * Create Transitions Settings
	 */
	function &createTransitions(&$node, $params){
		$node = &modVinaoraCu3erHelper::createTransition($node, $params, 0);
		return $node;
	}

	/*
	 * Create A Button.
	 * $name: Previous Button, Next Button, Previous Symbol, Next Symbol, Auto Load, Preloader, Description Box
	 */
	function &createButton(&$node, $name, $childs, $attbs){

		if (empty($name)) return;

		$nodeL1 = & $node->addChild($name);

		foreach ($childs as $child){

			if (empty($child)) continue;
			
			$nodeL2 = & $nodeL1->addChild($child);

			if (array_key_exists($child, $attbs)){
				$attb = $attbs[$child];
				if (isset($attb)){
					modVinaoraCu3erHelper::addAttributes($nodeL2, $attb);
				}
			}
		}

		return $node;
	}

	/*
	 * Add the attributes to a node
	 */
	function &addAttributes(&$node, $attbs){

		if (empty($attbs)) return;

		foreach ($attbs as $key=>$value){

			if (trim($value)=="") continue;
			$node->addAttribute($key, $value);
		}

		return $node;
	}

	/*
	 * Create Element <slides>
	 */
	function &createSlides(&$node, $params){

		$nodeL1 =& $node->addChild('Slides');

		$slides = explode("\n", $params->get('slide_url'));

		for($i=1; $i<=count($slides); $i++){
			$nodeL2 = modVinaoraCu3erHelper::createSlide($nodeL1, $params, $i);
			if ($params->get('transition_type') != 'none'){
				$nodeL2 = modVinaoraCu3erHelper::createTransition($nodeL1, $params, $i);
			}
		}

		return $node;
	}

	/*
	 * Create Element <slide>
	 * Default: Return the First Slide
	 */
	function &createSlide(&$node, $params, $position=1){

		$nodeL0 =& $node->addChild('slide');
		$found = false;

		$param = $params->get('slide_url');
		$str = trim( modVinaoraCu3erHelper::getParam($param, $position, "\n") );
		$str = modVinaoraCu3erHelper::validImageUrl($str);
		if ( strlen($str) ){
			$found = true;
			$nodeL1 =& $nodeL0->addChild('url');
			$nodeL1->setData($str);
		}

		$param = $params->get('slide_link');
		$str = trim ( modVinaoraCu3erHelper::getParam($param, $position, "\n") );
		if ( strlen($str) ){
			$found = true;
			$nodeL1 =& $nodeL0->addChild('link');
			$nodeL1->setData($str);

			$param = $params->get('slide_link_target');
			$attb = trim ( modVinaoraCu3erHelper::getParam($param, $position, "\n") );
			$attb = modVinaoraCu3erHelper::validTarget($attb);
			if ( strlen($str) ){
				$nodeL1->addAttribute('target', $attb);
			}
		}

		if ($params->get('enable_description_box')){

			$nodeL1 =& $nodeL0->addChild('description');

			$param = $params->get('slide_description_heading');
			$str = trim( modVinaoraCu3erHelper::getParam($param, $position, "\n") );
			if ( strlen($str) ){
				$found = true;
				$nodeL2 =& $nodeL1->addChild('heading');
				$nodeL2->setData($str);
			}

			$param = $params->get('slide_description_paragraph');
			$str = trim( modVinaoraCu3erHelper::getParam($param, $position, "\n") );
			if ( strlen($str) ){
				$found = true;
				$nodeL2 =& $nodeL1->addChild('paragraph');
				$nodeL2->setData($str);
			}

			$param = $params->get('slide_description_link');
			$str = trim ( modVinaoraCu3erHelper::getParam($param, $position, "\n") );
			if ( strlen($str) ){
				$found = true;
				$nodeL2 =& $nodeL1->addChild('link');
				$nodeL2->setData($str);

				$param = $params->get('slide_description_link_target');
				$attb = trim ( modVinaoraCu3erHelper::getParam($param, $position, "\n") );
				$attb = modVinaoraCu3erHelper::validTarget($attb);
				if ( strlen($attb) ){
					$nodeL2->addAttribute('target', $attb);
				}
			}
		}

		if (!$found) $node->removeChild($nodeL0);

		return $node;
	}

	/*
	 * Create Element <transiton> for slide
	 */
	function &createTransition(&$node, $params, $position=1){

		if ($position){
			$nodeL1 = $node->addChild('transition');
		}
		else{
			$nodeL1 = $node->addChild('transitions');
			$position = 1;
		}

		$attbs = array("num", "slicing", "direction", "duration", "delay", "shader", "light_position", "cube_color", "z_multiplier");
		$found = false;
		
		$a_slicing		= array("horizontal", "vertical");
		$a_direction	= array("left", "right", "up", "down");
		$a_shader		= array("none", "flat", "phong");
		
		if ($params->get('transition_type') == 'auto'){

			$nodeL1->addAttribute('num',		mt_rand(1, 5) );
			$nodeL1->addAttribute('slicing',	$a_slicing[mt_rand(0, count($a_slicing)-1)] );
			$nodeL1->addAttribute('direction',	$a_direction[mt_rand(0, count($a_direction)-1)] );
			$nodeL1->addAttribute('duration',	mt_rand(1, 5) / 10);
			$nodeL1->addAttribute('delay',		mt_rand(1, 5) / 10);
			$nodeL1->addAttribute('shader',		$a_shader[mt_rand(0, count($a_shader)-1)] );

			$found = true;
		}
		else{

			foreach ($attbs as $value){
				$param = $params->get('transition_'.$value);
				$str = modVinaoraCu3erHelper::getParam($param, $position);
				if ( strlen($str) ){
					$nodeL1->addAttribute($value, $str);
					$found = true;
				}
			}
		}
		
		// Check $node->data ???
		// Remove Child if have no attributes
		if (!$found) $node->removeChild($nodeL1);

		return $node;
	}

	/*
	 * GetTween by Type: In/TweenIn, Out/TweenOut, Over/TweenOver
	 */
	function getTween($param, $type='in'){

		$type = trim(strtolower($type));
		$return = NULL;

		switch($type){

			case 'in':
			case 'tweenin':
				$return = modVinaoraCu3erHelper::getParam($param, 1);
				break;

			case 'out':
			case 'tweenout':
				$return = modVinaoraCu3erHelper::getParam($param, 2);
				break;

			case 'over':
			case 'tweenover':
				$return = modVinaoraCu3erHelper::getParam($param, 3);
				break;

			default:
				return NULL;
				break;
		}

		return $return;

	}

	/*
	 * Get a Parameter in a String Parameters which are seperated with a specify symbol (default: vertical bar '|').
	 * Example: Parameters = "value1 | value2 | value3". Return "value2" if positon = 2
	 */
	function getParam($param, $position=1, $symbol='|'){

		$return = NULL;

		$items = explode($symbol, $param);

		if ( ($position > count($items)) || ($position<1) ) return NULL;
		else {
			$return = trim($items[$position-1]);
			if ( !strlen($return) ) return NULL;
		}

		return $return;
	}

	function &getTweenArray($params, $type, $name){
		$return = array();
		$keys = array("time", "delay", "x", "y", "width", "height", "rotation", "alpha", "tint", "scaleX", "scaleY");

		foreach ($keys as $key){
			$return[$key] = modVinaoraCu3erHelper::getTween($params->get($name."_".$key), $type);
		}

		return $return;
	}

	/*
	 * Add SWFObject Library to <head> tag
	 */
	function addSWFObject($swfobject){

		switch($swfobject){

			// Use Local file
			case 'i2.0':
			case 'i2.1':
			case 'i2.2':
				$version = substr($swfobject, 1);
				$path = 'media/mod_vinaora_cu3er/js/swfobject/'.$version.'/';
				JHTML::script('swfobject.js', $path);
				break;

			// Use Google Hosting
			case 'e2.1':
			case 'e2.2':
				$version = substr($swfobject, 1);
				$path = 'http://ajax.googleapis.com/ajax/libs/swfobject/'.$version.'/';
				JHTML::script('swfobject.js', $path);
				break;

			case '0':
			default:
				return;
				break;
		}

	}

	/*
	 * Get Attributes by Element Path
	 */
	function getAttributes($config, $path, $name = null ){

		$node = $config->document;

		if ($node) $node = $node->getElementByPath($path);
		else return;

		if ($node) $attb = $node->attributes($name);
		else return;

		return $attb;
	}
	
	/*
	 * Get List of Images from a Folder
	 */
	function getImages($folder, $fullpath=false){
	
		jimport('joomla.filesystem.folder');
		$filter 	= '\.png$|\.gif$|\.jpg$|\.bmp$';
		$exclude	= array('index.html', '.htaccess');
	
		switch($folder){
			case '-1':
				$images = NULL;
				break;

			case '':
				$images =  JFolder::files(JPATH_BASE.DS.'media'.DS.'mod_vinaora_cu3er'.DS.'images'.DS.'default', $filter, false, $fullpath, $exclude);
				break;

			default:
				$images =  JFolder::files(JPATH_BASE.DS.'images'.DS.'stories'.DS.$folder, $filter, false, $fullpath, $exclude);
				break;
		}

		return $images;

	}
	
	/*
	 * Get Image Path
	 */
	function getImagePath($folder){
		
		switch($folder){
			case '-1':
				$path = NULL;
				break;
			
			case '':
				$path = '/media/mod_vinaora_cu3er/images/default';
				$path = JURI::base(true) == '/' ? $path : JURI::base(true).$path;
				break;
			
			default:
				$path = '/images/stories/'.$folder;
				$path = JURI::base(true) == '/' ? $path : JURI::base(true).$path;
				break;
		}
		
		return $path;
		
	}
	
	/*
	 * Get List of Image URLs
	 */
	function getImageURLs($folder){
		$path 	= modVinaoraCu3erHelper::getImagePath($folder);
		$images	= modVinaoraCu3erHelper::getImages($folder);
		
		if (count($images)){
			foreach($images as $key=>$value){
				$images[$key] = $path.'/'.$value;
			}
		}

		return $images;
	}

	/*
	 * Valid Image Url
	 */
	function validImageUrl($url){

		$url = parse_url($url);
		$url = $url["path"];

		return $url;
	}

	/*
	 * Valid Link Target
	 */
	function validTarget($target = '_blank'){
		$target = strtolower($target);
		$target = strpos($target, '_') === false ? '_'.$target : $target;

		$valid = array ('_blank', '_top', '_parent', '_self');
		$target = in_array($target, $valid) ? $target : '_blank';
		
		return $target;
	}
	
	/*
	 * Get Random Color
	 */
	function rand_color() {
		return substr('00000' . dechex(mt_rand(0, 0xffffff)), -6);
	}
	
	/*
	 * Replace TweenName from lowercase to pascalName format
	 */
	function &replaceTweenName(&$str){

		$str = str_replace('<tweenin ', '<tweenIn ', $str);
		$str = str_replace('<tweenout ', '<tweenOut ', $str);
		$str = str_replace('<tweenover ', '<tweenOver ', $str);
		
		return $str;
	}
}
