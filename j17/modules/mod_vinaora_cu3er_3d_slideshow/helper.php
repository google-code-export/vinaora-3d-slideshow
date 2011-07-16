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

class modVinaoraCu3er3DSlideshowHelper
{
	private $params;
	private $separator = "\n";
	private $tweenNames = array("defaults", "tweenIn", "tweenOut", "tweenOver");
	private $buttonNames = array("prev_button", "next_button", "prev_symbol", "next_symbol", "auto_play", "preloader", "description");

	function __construct(&$params){
		$this->params = $params;

		// var_dump($this->params);
	}
	
	/*
	 * Get content of the config file
	 */
	public function getConfig($name){

		$xml = false;
		$name = JPath::clean($name);

		//Remove the Directory Separator (DS) at the begin of $name if exits
		$name = ltrim($name, DS);
		
		if ( !is_file(JPATH_BASE.DS.$name) ){
			JError::raiseNotice('0', JText::_('MOD_VINAORA_CU3ER_3D_SLIDESHOW_ERROR_FILE_CONFIG_NOTFOUND'));
			return false;
		}

		// $ext = pathinfo($filename, PATHINFO_EXTENSION);
		$ext = strtolower(substr($name, -4, 4));
		
		// Load from file if it is .xml
		if ( $ext == '.xml' ){
			$xml = simplexml_load_file( JPATH_BASE.DS.$name );
		}
		// Load from URL if it is .xml.php
		elseif ( $ext == '.xml.php' ) {
			$xml = simplexml_load_file( JURI::base().JPath::clean($name, '/') );
		}
		else{
			JError::raiseNotice('0', JText::_('MOD_VINAORA_CU3ER_3D_SLIDESHOW_ERROR_FILE_CONFIG_INVALID'));
			return false;
		}

		return $xml;

	}
	
	/*
	 * Create the config file
	 */
	public function createConfig($name){

		jimport('joomla.filesystem.file');
		$name = JPath::clean($name);

		//Remove the Directory Separator (DS) at the begin of $name if exits
		$name = ltrim($name, DS);

		$name = JPATH_BASE.DS.$name;

		if ( is_writeable(dirname($name)) ){
			if ( JFile::write($name, $this->getXML()) ) return true;
			else{
				JError::raiseNotice('0', JText::_('MOD_VINAORA_CU3ER_3D_SLIDESHOW_ERROR_FILE_UNWRITABLE'));
			}
		}
		else{
			// Folder is not writeable
			JError::raiseNotice('0', JText::_('MOD_VINAORA_CU3ER_3D_SLIDESHOW_ERROR_DIRECTORY_UNWRITABLE'));
		}

		return false;

	}
	
	/*
	 * Create content of the config file
	 */
	public function getXML(){
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		
		// Create Element - <cu3er>
		$node = new SimpleXMLElement($xml.'<cu3er />');
		
		// Create Element - <cu3er>.<settings>
		$nodeL1 =& $node->addChild('settings');
		
		// Create Element - <cu3er>.<settings>.<general>
		$nodeL2 =& $this->_createGeneral($nodeL1);

		// Create Element - <cu3er>.<settings>.<debug>
		if ($this->params->get('enable_debug')){
			$nodeL2 =& $this->_createDebug($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<auto_play>
		if ($this->params->get('enable_auto_play')){
			$nodeL2 =& $this->_createAutoPlay($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<pre_button>
		if ($this->params->get('enable_prev_button')){
			$nodeL2 =& $this->_createPreviousButton($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<pre_symbol>
		if ($this->params->get('enable_prev_symbol')){
			$nodeL2 =& $this->_createPreviousSymbol($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<next_button>
		if ($this->params->get('enable_next_button')){
			$nodeL2 =& $this->_createNextButton($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<next_symbol>
		if ($this->params->get('enable_next_symbol')){
			$nodeL2 =& $this->_createNextSymbol($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<preloader>
		if ($this->params->get('enable_preloader')){
			$nodeL2 =& $this->_createPreloader($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<description>
		if ($this->params->get('enable_description_box')){
			$nodeL2 =& $this->_createDescriptionBox($nodeL1);
		}

		// Create Element - <cu3er>.<settings>.<transitions>
		if ($this->params->get('transition_type') == 'first'){
			$nodeL2 =& $this->_createTransitions($nodeL1);
		}

		// Create Element - <cu3er>.<slides>
		$nodeL2 =& $this->_createSlides($node);
		
		$xml = $node->asXML();
		
		$xml = self::replaceTweenName($xml);

		return $xml;
	}
	
	/*
	 * Create General Settings
	 */
	private function _createGeneral(&$node){
		
		$general = array();
		
		$general["slide_panel_width"] 				= intval( $this->params->get('slide_panel_width') );
		$general["slide_panel_height"] 				= intval( $this->params->get('slide_panel_height') );
		$general["slide_panel_horizontal_align"] 	= $this->params->get('slide_panel_horizontal_align');
		$general["slide_panel_vertical_align"] 		= $this->params->get('slide_panel_vertical_align');
		$general["ui_visibility_time"] 				= intval( $this->params->get('ui_visibility_time') );

		// Create Element - <cu3er>.<settings>.<general>
		$nodeL1 =& $node->addChild('general');

		// Create Attributes of <cu3er>.<settings>.<general>
		self::addAttributes($nodeL1, $general);

		return $node;
	}
	
	/*
	 * Create Debug Settings
	 */
	private function _createDebug(&$node){
		
		$debug = array();

		$debug["x"]	= intval( $this->params->get('debug_x') );
		$debug["y"]	= intval( $this->params->get('debug_y') );

		// Create Element - <cu3er>.<settings>.<debug>
		$nodeL1 =& $node->addChild('debug');

		// Create Attributes of <cu3er>.<settings>.<debug>
		self::addAttributes($nodeL1, $debug);

		return $node;
	}

	/*
	 * Create Auto-Play Settings
	 */
	private function _createAutoPlay(&$node){

		$name = "auto_play";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"symbol"	=> $this->params->get('auto_play_symbol', 'linear'),
				"time"		=> $this->params->get('auto_play_time_defaults', 5)
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($name, 'in');
		$attbs["tweenOut"]	=& $this->getTweenArray($name, 'out');
		$attbs["tweenOver"]	=& $this->getTweenArray($name, 'over');

		// Create Element - <cu3er>.<settings>.<auto_play>
		$nodeL1 = $this->createButton($node, $name, $this->tweenNames, $attbs);

		return $node;
	}
	
	/*
	 * Create Previous Button Settings
	 */
	private function _createPreviousButton(&$node){

		$name = "prev_button";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"round_corners" => $this->params->get('prev_button_round_corners', '0, 0, 0, 0')
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($name, 'in');
		$attbs["tweenOut"]	=& $this->getTweenArray($name, 'out');
		$attbs["tweenOver"]	=& $this->getTweenArray($name, 'over');

		// Create Element - <cu3er>.<settings>.<prev_button>
		$nodeL1 = $this->createButton($node, $name, $this->tweenNames, $attbs);

		return $node;
	}

	/*
	 * Create Previous Symbol Settings
	 */
	private function _createPreviousSymbol(&$node){

		$name = "prev_symbol";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"type" => $this->params->get('prev_symbol_type', '1')
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($name, 'in');
		$attbs["tweenOut"]	=& $this->getTweenArray($name, 'out');
		$attbs["tweenOver"]	=& $this->getTweenArray($name, 'over');

		// Create Element - <cu3er>.<settings>.<prev_symbol>
		$nodeL1 = $this->createButton($node, $name, $this->tweenNames, $attbs);

		return $node;
	}

	/*
	 * Create Next Button Settings
	 */
	private function _createNextButton(&$node){

		$name = "next_button";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"round_corners" => $this->params->get('next_button_round_corners', '0, 0, 0, 0')
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($name, 'in');
		$attbs["tweenOut"]	=& $this->getTweenArray($name, 'out');
		$attbs["tweenOver"]	=& $this->getTweenArray($name, 'over');

		// Create Element - <cu3er>.<settings>.<next_button>
		$nodeL1 = $this->createButton($node, $name, $this->tweenNames, $attbs);

		return $node;
	}

	/*
	 * Create Next Symbol Settings
	 */
	private function _createNextSymbol(&$node){

		$name = "next_symbol";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"type" => $this->params->get('next_symbol_type', '1')
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($name, 'in');
		$attbs["tweenOut"]	=& $this->getTweenArray($name, 'out');
		$attbs["tweenOver"]	=& $this->getTweenArray($name, 'over');

		// Create Element - <cu3er>.<settings>.<next_symbol>
		$nodeL1 = $this->createButton($node, $name, $this->tweenNames, $attbs);

		return $node;
	}
	
	/*
	 * Create Preloader Settings
	 */
	private function _createPreloader(&$node){

		$name = "preloader";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"symbol" => $this->params->get('preloader_symbol', 'linear')
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($name, 'in');
		$attbs["tweenOut"]	=& $this->getTweenArray($name, 'out');
		// $attbs["tweenOver"]	=& $this->getTweenArray($name, 'over');

		// Create Element - <cu3er>.<settings>.<preloader>
		$nodeL1 = $this->createButton($node, $name, $this->tweenNames, $attbs);

		return $node;
	}

	/*
	 * Create Description Box Settings
	 */
	private function _createDescriptionBox(&$node){

		$name = "description";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"round_corners" 				=> $this->params->get('description_round_corners', '0, 0, 0, 0'),
				"heading_font" 					=> $this->params->get('description_heading_font', 'Georgia'),
				"heading_text_size" 			=> $this->params->get('description_heading_text_size', '18'),
				"heading_text_color" 			=> $this->params->get('description_heading_text_color', '0x000000'),
				"heading_text_align" 			=> $this->params->get('description_heading_text_align', 'left'),
				"heading_text_margin" 			=> $this->params->get('description_heading_text_margin', '10, 25, 0, 25'),
				"heading_text_leading" 			=> $this->params->get('description_heading_text_leading', '0'),
				"heading_text_letterSpacing"	=> $this->params->get('description_heading_text_letterSpacing', '0'),
				"paragraph_font" 				=> $this->params->get('description_paragraph_font', 'Arial'),
				"paragraph_text_size" 			=> $this->params->get('description_paragraph_text_size', '12'),
				"paragraph_text_color" 			=> $this->params->get('description_paragraph_text_color', '0x000000'),
				"paragraph_text_align" 			=> $this->params->get('description_paragraph_text_align', 'left'),
				"paragraph_text_margin" 		=> $this->params->get('description_paragraph_text_margin', '5, 25, 0, 25'),
				"paragraph_text_leading" 		=> $this->params->get('description_paragraph_text_leading', '0'),
				"paragraph_text_letterSpacing" 	=> $this->params->get('description_paragraph_text_letterSpacing', '0')
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($name, 'in');
		$attbs["tweenOut"]	=& $this->getTweenArray($name, 'out');
		$attbs["tweenOver"]	=& $this->getTweenArray($name, 'over');

		// Create Element - <cu3er>.<settings>.<description>
		$nodeL1 = $this->createButton($node, $name, $this->tweenNames, $attbs);

		return $node;
	}
	
	/*
	 * Create Transitions Settings
	 */
	private function _createTransitions(&$node){
		
		$node =& $this->_createTransition($node, 0);
		
		return $node;
	}
	
	/*
	 * Create Element <transiton> for slide
	 */
	private function _createTransition(&$node, $position=1){

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
		
		if ($this->params->get('transition_type') == 'auto'){

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
				$param = $this->params->get('transition_'.$value);
				$str = trim( self::getParam($param, $position) );
				if ( strlen($str) ){
					$nodeL1->addAttribute($value, $str);
					$found = true;
				}
			}
		}

		// Remove Child if have no attributes
		// if (!$found) $node->removeChild($nodeL1);

		return $node;
	}

	/*
	 * Create A Button.
	 * $name: Previous Button, Next Button, Previous Symbol, Next Symbol, Auto Load, Preloader, Description Box
	 */
	private function createButton(&$node, $name, $childNames, $attbs){

		if (!in_array($name, $this->buttonNames)) return;

		$nodeL1 =& $node->addChild($name);

		foreach ($childNames as $child){

			if (empty($child)) continue;
			
			$nodeL2 =& $nodeL1->addChild($child);

			if (array_key_exists($child, $attbs)){
				$attb = $attbs[$child];
				if (isset($attb)){
					self::addAttributes($nodeL2, $attb);
				}
			}
		}

		return $node;
	}
	
	/*
	 * Add the attributes to a node
	 */
	public static function addAttributes(&$node, $attbs){

		if(is_array($attbs)){

			foreach ($attbs as $key=>$value){
				$value = trim($value);
				if (strlen($value)){
					$node->addAttribute($key, $value);
				}
			}
		}

		return $node;
	}
	
	/*
	 * Create Element <slides>
	 */
	private function _createSlides(&$node){

		$nodeL1 =& $node->addChild('Slides');

		$slides = explode("\n", $this->params->get('slide_url'));

		for($i=1; $i<=count($slides); $i++){
			$nodeL2 = $this->_createSlide($nodeL1, $i);
			if ($this->params->get('transition_type') != 'none'){
				$nodeL2 = $this->_createTransition($nodeL1, $i);
			}
		}

		return $node;
	}
	
	/*
	 * Create Element <slide>
	 * Default: Return the First Slide
	 */
	private function _createSlide(&$node, $position=1){

		$nodeL0 =& $node->addChild('slide');
		$found = false;

		$param = $this->params->get('slide_url');
		$str = trim( self::getParam($param, $position, $this->separator) );
		$str = self::validImageURL($str);
		if ( strlen($str) ){
			$found = true;
			$nodeL1 =& $nodeL0->addChild('url', $str);
		}

		$param = $this->params->get('slide_link');
		$str = trim ( self::getParam($param, $position, $this->separator) );
		if ( strlen($str) ){
			$found = true;
			$nodeL1 =& $nodeL0->addChild('link', $str);

			$param = $this->params->get('slide_link_target');
			$attb = trim ( self::getParam($param, $position, $this->separator) );
			$attb = self::validTarget($attb);
			if ( strlen($attb) ){
				$nodeL1->addAttribute('target', $attb);
			}
		}

		$param = $this->params->get('enable_description_box');
		if ( strlen($param) ){

			$nodeL1 =& $nodeL0->addChild('description');

			$param = $this->params->get('slide_description_heading');
			$str = trim( self::getParam($param, $position, $this->separator) );
			if ( strlen($str) ){
				$found = true;
				$nodeL2 =& $nodeL1->addChild('heading', $str);
			}

			$param = $this->params->get('slide_description_paragraph');
			$str = trim( self::getParam($param, $position, $this->separator) );
			if ( strlen($str) ){
				$found = true;
				$nodeL2 =& $nodeL1->addChild('paragraph', $str);
			}

			$param = $this->params->get('slide_description_link');
			$str = trim ( self::getParam($param, $position, $this->separator) );
			if ( strlen($str) ){
				$found = true;
				$nodeL2 =& $nodeL1->addChild('link', $str);

				$param = $this->params->get('slide_description_link_target');
				$attb = trim ( self::getParam($param, $position, $this->separator) );
				$attb = self::validTarget($attb);
				if ( strlen($attb) ){
					$nodeL2->addAttribute('target', $attb);
				}
			}
		}

		// if (!$found) $node->removeChild($nodeL0);

		return $node;
	}
	
	private function getTweenArray($name, $type){
		$tween = array();
		
		$keys = array("time", "delay", "x", "y", "width", "height", "rotation", "alpha", "tint", "scaleX", "scaleY");

		foreach ($keys as $key){
			$tween[$key] = self::getTween($this->params->get($name."_".$key), $type);
		}

		return $tween;
	}

	/*
	 * GetTween by Type: In/TweenIn, Out/TweenOut, Over/TweenOver
	 */
	private static function getTween($param, $type='in'){

		$type = strtolower(trim($type));
		$return = NULL;

		switch($type){

			case 'in':
			case 'tweenin':
				$return = self::getParam($param, 1);
				break;

			case 'out':
			case 'tweenout':
				$return = self::getParam($param, 2);
				break;

			case 'over':
			case 'tweenover':
				$return = self::getParam($param, 3);
				break;
		}

		return $return;

	}
	
	/*
	 * Get a Parameter in a String Parameters which are seperated with a separator symbol (default: vertical bar '|').
	 * Example: Parameters = "value1 | value2 | value3". Return "value2" if positon = 2
	 */
	public static function getParam($param, $position=1, $separator='|'){

		$return = NULL;
		
		if(!empty($param)){

			$items = explode($separator, $param);

			if ( ($position > count($items)) || ($position<1) ) return NULL;
			else {
				$return = trim( $items[$position-1] );
				if ( !strlen($return) ) return NULL;
			}
		}

		return $return;
	}

	/*
	 * Validate Link Target
	 */
	public static function validTarget($target = '_blank'){
		$target = strtolower(trim($target));
		$target = "_".ltrim($target, '_');

		$valid = array ('_blank', '_top', '_parent', '_self');
		$target = in_array($target, $valid) ? $target : '_blank';

		return $target;
	}

	/*
	 *
	 */
	public static function validImageURL($str){
		
	}

	/*
	 * Replace TweenName from lowercase to pascalName format
	 */
	private static function replaceTweenName($str){

		$str = str_replace('<tweenin ', '<tweenIn ', $str);
		$str = str_replace('<tweenout ', '<tweenOut ', $str);
		$str = str_replace('<tweenover ', '<tweenOver ', $str);

		return $str;
	}

	/*
	 * Add SWFObject Library to <head> tag
	 */
	public static function addSWFObject($source='local', $version='2.2'){
		
		if($source == 'local'){
			JHTML::script("media/mod_vinaora_cu3er_3d_slideshow/js/swfobject/$version/swfobject.min.js");
			return true;
		}
		
		if($source == 'google'){
			JHTML::script("https://ajax.googleapis.com/ajax/libs/swfobject/$version/swfobject.min.js");
			return true;
		}
		
		return false;

	}	
}