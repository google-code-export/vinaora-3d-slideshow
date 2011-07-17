<?php
/**
 * @version		$Id: lastedit.php 2011-07-20 vinaora $
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
 
jimport('joomla.form.formfield');
 
class JFormFieldLastEdit extends JFormField {
 
	protected $type = 'LastEdit';
 
	public function getInput() {
		$config = &JFactory::getConfig();
		$offset	= $config->getValue('config.offset');
		
		$now = &JFactory::getDate();
		$now->setOffset($offset);
		
		$value	= $now->toFormat('%Y%m%d-%H%M%S');

		return '<input readonly="readonly" type="hidden" id="'.$this->id.'" name="'.$this->name.'" value="'.$value.'" size="50">';
	}
	
	public function getLabel(){
        
		// Initialize variables.
        $label = '';
 
        // Get the label text from the XML element, defaulting to the element name.
        $text = $this->element['label'] ? (string) $this->element['label'] : (string) $this->element['name'];
 
        // Build the class for the label.
        $class = !empty($this->description) ? 'hasTip' : '';
        $class = $this->required == true ? $class.' required' : $class;
 
        // Add the opening label tag and main attributes attributes.
        $label .= '<label id="'.$this->id.'-lbl" for="'.$this->id.'" class="'.$class.'" style="display:none;"';
 
        // If a description is specified, use it to build a tooltip.
        if (!empty($this->description)) {
            $label .= ' title="'.htmlspecialchars(trim(JText::_($text), ':').'::' .
                        JText::_($this->description), ENT_COMPAT, 'UTF-8').'"';
        }
 
        // Add the label text and closing tag.
        $label .= '>'.JText::_($text).'</label>';
 
        return $label;
	}
}