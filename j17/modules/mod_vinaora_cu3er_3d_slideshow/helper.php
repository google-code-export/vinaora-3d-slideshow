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
	
	protected __contruct(){
	}
	
	/*
	 * Create General Settings
	 */
	protected function _createGeneral(&$node){
		
		$params = $this->$params;
		
		$general = array();
		
		$general["slide_panel_width"] 				= intval( $params->get('slide_panel_width') );
		$general["slide_panel_height"] 				= intval( $params->get('slide_panel_height') );
		$general["slide_panel_horizontal_align"] 	= $params->get('slide_panel_horizontal_align');
		$general["slide_panel_vertical_align"] 		= $params->get('slide_panel_vertical_align');
		$general["ui_visibility_time"] 				= intval( $params->get('ui_visibility_time') );

		// Create Element - <cu3er>.<settings>.<general>
		$nodeL1 =& $node->addChild('general');

		// Create Attributes of <cu3er>.<settings>.<general>
		$this->addAttributes($nodeL1, $general);

		return $node;
	}
	
	/*
	 * Create Debug Settings
	 */
	protected function _createDebug($node){

		$params = $this->$params;
		
		$debug = array();

		$debug["x"]	= intval( $params->get('debug_x') );
		$debug["y"]	= intval( $params->get('debug_y') );

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

		$params = $this->$params;
		
		$childnaname = array("defaults", "tweenIn", "tweenOut", "tweenOver");
		$name = "auto_play";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"symbol"	=> $params->get('auto_play_symbol', 'linear'),
				"time"		=> $params->get('auto_play_time_defaults', 5)
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($params, 'in', $name);
		$attbs["tweenOut"]	=& $this->getTweenArray($params, 'out', $name);
		$attbs["tweenOver"]	=& $this->getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<auto_play>
		$nodeL1 = $this->createButton($node, $name, $childnaname, $attbs);

		return $node;
	}
	
	/*
	 * Create Previous Button Settings
	 */
	protected function _createPreviousButton(&$node){

		$params = $this->$params;
		
		$childnaname = array("defaults", "tweenIn", "tweenOut", "tweenOver");
		$name = "prev_button";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"round_corners" => $params->get('prev_button_round_corners', '0, 0, 0, 0')
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($params, 'in', $name);
		$attbs["tweenOut"]	=& $this->getTweenArray($params, 'out', $name);
		$attbs["tweenOver"]	=& $this->getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<prev_button>
		$nodeL1 = $this->createButton($node, $name, $childnaname, $attbs);

		return $node;
	}
	
	/*
	 * Create Next Button Settings
	 */
	protected function _createNextButton(&$node){
	
		$params = $this->$params;

		$childnaname = array("defaults", "tweenIn", "tweenOut", "tweenOver");
		$name = "next_button";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"round_corners" => $params->get('next_button_round_corners', '0, 0, 0, 0')
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($params, 'in', $name);
		$attbs["tweenOut"]	=& $this->getTweenArray($params, 'out', $name);
		$attbs["tweenOver"]	=& $this->getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<next_button>
		$nodeL1 = $this->createButton($node, $name, $childnaname, $attbs);

		return $node;
	}

	/*
	 * Create Next Symbol Settings
	 */
	protected function _createNextSymbol(&$node){

		$params = $this->$params;
		
		$childnaname = array("defaults", "tweenIn", "tweenOut", "tweenOver");
		$name = "next_symbol";

		$attbs = array();
		$attbs["defaults"]  = 
			array(
				"type" => $params->get('next_symbol_type', '1')
			);
		$attbs["tweenIn"]	=& $this->getTweenArray($params, 'in', $name);
		$attbs["tweenOut"]	=& $this->getTweenArray($params, 'out', $name);
		$attbs["tweenOver"]	=& $this->getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<next_symbol>
		$nodeL1 = $this->createButton($node, $name, $childnaname, $attbs);

		return $node;
	}
	
	/*
	 * Create Description Box Settings
	 */
	protected function _createDescriptionBox(&$node){

		$params = $this->$params;
		
		$childnaname = array("defaults", "tweenIn", "tweenOut", "tweenOver");
		$name = "description";

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
		$attbs["tweenIn"]	=& $this->getTweenArray($params, 'in', $name);
		$attbs["tweenOut"]	=& $this->getTweenArray($params, 'out', $name);
		$attbs["tweenOver"]	=& $this->getTweenArray($params, 'over', $name);

		// Create Element - <cu3er>.<settings>.<description>
		$nodeL1 = $this->createButton($node, $name, $childnaname, $attbs);

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
	 * Create A Button.
	 * $name: Previous Button, Next Button, Previous Symbol, Next Symbol, Auto Load, Preloader, Description Box
	 */
	function createButton(&$node, $name, $childs, $attbs){

		$names = array("prev_button", "next_button", "prev_symbol", "next_symbol", "auto_play", "preloader", "description");
		
		if (!in_array($name, $names)) return;

		$nodeL1 =& $node->addChild($name);

		foreach ($childs as $child){

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
	function addAttributes(&$node, $attbs){

		if(!empty($attbs) && is_array($attbs)){

			foreach ($attbs as $key=>$value){
				$value = trim($value);
				if (!empty($value)){
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
	
		$params = $this->$params;

		$nodeL1 =& $node->addChild('Slides');

		$slides = explode("\n", $params->get('slide_url'));

		for($i=1; $i<=count($slides); $i++){
			$nodeL2 = $this->createSlide($nodeL1, $params, $i);
			if ($params->get('transition_type') != 'none'){
				$nodeL2 = $this->createTransition($nodeL1, $params, $i);
			}
		}

		return $node;
	}
	
	/*
	 * Create Element <slide>
	 * Default: Return the First Slide
	 */
	function createSlide(){
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
	
	function getTweenArray($type, $name){
		$return = array();
		
		$keys = array("time", "delay", "x", "y", "width", "height", "rotation", "alpha", "tint", "scaleX", "scaleY");

		foreach ($keys as $key){
			$return[$key] = $this->getTween($params->get($name."_".$key), $type);
		}

		return $return;
	}

}