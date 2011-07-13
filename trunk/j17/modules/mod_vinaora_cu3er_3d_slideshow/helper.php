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
	private var $params;
	private var $module_id;
	private var $tweenNames;
	private var $buttonNames;
	
	protected __contruct(){
		$tweenNames = array("defaults", "tweenIn", "tweenOut", "tweenOver");
		$buttonNames = array("prev_button", "next_button", "prev_symbol", "next_symbol", "auto_play", "preloader", "description");
	}
	
	/*
	 * Create General Settings
	 */
	protected function _createGeneral(&$node){
		
		$general = array();
		
		$general["slide_panel_width"] 				= intval( $this->params->get('slide_panel_width') );
		$general["slide_panel_height"] 				= intval( $this->params->get('slide_panel_height') );
		$general["slide_panel_horizontal_align"] 	= $this->params->get('slide_panel_horizontal_align');
		$general["slide_panel_vertical_align"] 		= $this->params->get('slide_panel_vertical_align');
		$general["ui_visibility_time"] 				= intval( $this->params->get('ui_visibility_time') );

		// Create Element - <cu3er>.<settings>.<general>
		$nodeL1 =& $node->addChild('general');

		// Create Attributes of <cu3er>.<settings>.<general>
		$this->addAttributes($nodeL1, $general);

		return $node;
	}
	
	/*
	 * Create Debug Settings
	 */
	protected function _createDebug(&$node){
		
		$debug = array();

		$debug["x"]	= intval( $this->params->get('debug_x') );
		$debug["y"]	= intval( $this->params->get('debug_y') );

		// Create Element - <cu3er>.<settings>.<debug>
		$nodeL1 =& $node->addChild('debug');

		// Create Attributes of <cu3er>.<settings>.<debug>
		$this->addAttributes($nodeL1, $debug);

		return $node;
	}

	/*
	 * Create Auto-Play Settings
	 */
	protected function _createAutoPlay(&$node){

		$name = "auto_play";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"symbol"	=> $this->params->get('auto_play_symbol', 'linear'),
				"time"		=> $this->params->get('auto_play_time_defaults', 5)
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($params, 'in', $name);
		$attbs["tweenOut"]	=& $this->getTweenArray($params, 'out', $name);
		$attbs["tweenOver"]	=& $this->getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<auto_play>
		$nodeL1 = $this->createButton($node, $name, $this->tweenNames, $attbs);

		return $node;
	}
	
	/*
	 * Create Previous Button Settings
	 */
	protected function _createPreviousButton(&$node){

		$name = "prev_button";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"round_corners" => $this->params->get('prev_button_round_corners', '0, 0, 0, 0')
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($params, 'in', $name);
		$attbs["tweenOut"]	=& $this->getTweenArray($params, 'out', $name);
		$attbs["tweenOver"]	=& $this->getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<prev_button>
		$nodeL1 = $this->createButton($node, $name, $this->tweenNames, $attbs);

		return $node;
	}

	/*
	 * Create Previous Symbol Settings
	 */
	protected function _createPreviousSymbol(&$node){

		$name = 'prev_symbol';

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"type" => $this->params->get('prev_symbol_type', '1')
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($params, 'in', $name);
		$attbs["tweenOut"]	=& $this->getTweenArray($params, 'out', $name);
		$attbs["tweenOver"]	=& $this->getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<prev_symbol>
		$nodeL1 = $this->createButton($node, $name, $this->tweenNames, $attbs);

		return $node;
	}

	/*
	 * Create Next Button Settings
	 */
	protected function _createNextButton(&$node){

		$name = "next_button";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"round_corners" => $this->params->get('next_button_round_corners', '0, 0, 0, 0')
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($params, 'in', $name);
		$attbs["tweenOut"]	=& $this->getTweenArray($params, 'out', $name);
		$attbs["tweenOver"]	=& $this->getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<next_button>
		$nodeL1 = $this->createButton($node, $name, $this->tweenNames, $attbs);

		return $node;
	}

	/*
	 * Create Next Symbol Settings
	 */
	protected function _createNextSymbol(&$node){

		$name = "next_symbol";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"type" => $this->params->get('next_symbol_type', '1')
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($params, 'in', $name);
		$attbs["tweenOut"]	=& $this->getTweenArray($params, 'out', $name);
		$attbs["tweenOver"]	=& $this->getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<next_symbol>
		$nodeL1 = $this->createButton($node, $name, $this->tweenNames, $attbs);

		return $node;
	}
	
	/*
	 * Create Preloader Settings
	 */
	protected function _createPreloader(&$node){

		$name = 'preloader';

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"symbol" => $this->params->get('preloader_symbol', 'linear')
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($params, 'in', $name);
		$attbs["tweenOut"]	=& $this->getTweenArray($params, 'out', $name);

		// Create Element - <cu3er>.<settings>.<preloader>
		$nodeL1 = $this->createButton($node, $name, $this->tweenNames, $attbs);

		return $node;
	}

	/*
	 * Create Description Box Settings
	 */
	protected function _createDescriptionBox(&$node){

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
		$attbs["tweenIn"]	=& $this->getTweenArray($params, 'in', $name);
		$attbs["tweenOut"]	=& $this->getTweenArray($params, 'out', $name);
		$attbs["tweenOver"]	=& $this->getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<description>
		$nodeL1 = $this->createButton($node, $name, $this->tweenNames, $attbs);

		return $node;
	}
	
	/*
	 * Create Transitions Settings
	 */
	protected function _createTransitions(&$node){
		
		$params = $this->$params;
		
		$node =& $this->createTransition($node, $params, 0);
		
		return $node;
	}
	
	/*
	 * Create Element <transiton> for slide
	 */
	protected function _createTransition(&$node, $position=1){

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
				$str = $this->getParam($param, $position);
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
	 * Create A Button.
	 * $name: Previous Button, Next Button, Previous Symbol, Next Symbol, Auto Load, Preloader, Description Box
	 */
	protected function createButton(&$node, $name, $childNames, $attbs){

		if (!in_array($name, $this->buttonNames)) return;

		$nodeL1 =& $node->addChild($name);

		foreach ($childNames as $child){

			if (empty($child)) continue;
			
			$nodeL2 =& $nodeL1->addChild($child);

			if (array_key_exists($child, $attbs)){
				$attb = $attbs[$child];
				if (isset($attb)){
					$this->addAttributes($nodeL2, $attb);
				}
			}
		}

		return $node;
	}
	
	/*
	 * Add the attributes to a node
	 */
	protected function addAttributes(&$node, $attbs){

		if(is_array($attbs)){

			foreach ($attbs as $key=>$value){
				if (trim($value) != ''){
					$node->addAttribute($key, $value);
				}
			}
		}

		return $node;
	}
	
	/*
	 * Create Element <slides>
	 */
	protected function _createSlides(&$node){

		$nodeL1 =& $node->addChild('Slides');

		$slides = explode("\n", $this->params->get('slide_url'));

		for($i=1; $i<=count($slides); $i++){
			$nodeL2 = $this->createSlide($nodeL1, $i);
			if ($this->params->get('transition_type') != 'none'){
				$nodeL2 = $this->createTransition($nodeL1, $i);
			}
		}

		return $node;
	}
	
	/*
	 * Create Element <slide>
	 * Default: Return the First Slide
	 */
	function createSlide(&$node, $position=1){
		$separator = "\n";
		$nodeL0 =& $node->addChild('slide');
		$found = false;

		$param = $this->params->get('slide_url');
		$str = trim( $this->getParam($param, $position, $separator) );
		$str = $this->validImageUrl($str);
		if ( strlen($str) ){
			$found = true;
			$nodeL1 =& $nodeL0->addChild('url', $str);
		}

		$param = $this->params->get('slide_link');
		$str = trim ( $this->getParam($param, $position, $separator) );
		if ( strlen($str) ){
			$found = true;
			$nodeL1 =& $nodeL0->addChild('link', $str);

			$param = $this->params->get('slide_link_target');
			$attb = trim ( $this->getParam($param, $position, $separator) );
			$attb = $this->validTarget($attb);
			if ( strlen($str) ){
				$nodeL1->addAttribute('target', $attb);
			}
		}

		if ($this->params->get('enable_description_box')){

			$nodeL1 =& $nodeL0->addChild('description');

			$param = $this->params->get('slide_description_heading');
			$str = trim( $this->getParam($param, $position, $separator) );
			if ( strlen($str) ){
				$found = true;
				$nodeL2 =& $nodeL1->addChild('heading', $str);
			}

			$param = $this->params->get('slide_description_paragraph');
			$str = trim( $this->getParam($param, $position, $separator) );
			if ( strlen($str) ){
				$found = true;
				$nodeL2 =& $nodeL1->addChild('paragraph', $str);
			}

			$param = $this->params->get('slide_description_link');
			$str = trim ( $this->getParam($param, $position, $separator) );
			if ( strlen($str) ){
				$found = true;
				$nodeL2 =& $nodeL1->addChild('link', $str);

				$param = $this->params->get('slide_description_link_target');
				$attb = trim ( $this->getParam($param, $position, $separator) );
				$attb = $this->validTarget($attb);
				if ( strlen($attb) ){
					$nodeL2->addAttribute('target', $attb);
				}
			}
		}

		if (!$found) $node->removeChild($nodeL0);

		return $node;
	}
	
	/*
	 * GetTween by Type: In/TweenIn, Out/TweenOut, Over/TweenOver
	 */
	protected function getTween($param, $type='in'){

		$type = trim(strtolower($type));
		$return = NULL;

		switch($type){

			case 'in':
			case 'tweenin':
				$return = $this->getParam($param, 1);
				break;

			case 'out':
			case 'tweenout':
				$return = $this->getParam($param, 2);
				break;

			case 'over':
			case 'tweenover':
				$return = $this->getParam($param, 3);
				break;
		}

		return $return;

	}
	
	/*
	 * Get a Parameter in a String Parameters which are seperated with a specify symbol (default: vertical bar '|').
	 * Example: Parameters = "value1 | value2 | value3". Return "value2" if positon = 2
	 */
	public function getParam($param, $position=1, $symbol='|'){

		$return = NULL;

		$items = explode($symbol, $param);

		if ( ($position > count($items)) || ($position<1) ) return NULL;
		else {
			$return = trim($items[$position-1]);
			if ( !strlen($return) ) return NULL;
		}

		return $return;
	}
	
	protected function getTweenArray($type, $name){
		$tween = array();
		
		$keys = array("time", "delay", "x", "y", "width", "height", "rotation", "alpha", "tint", "scaleX", "scaleY");

		foreach ($keys as $key){
			$tween[$key] = $this->getTween($this->params->get($name."_".$key), $type);
		}

		return $tween;
	}

}