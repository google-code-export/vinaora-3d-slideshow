<?php
/**
* @version		$Id: multiimages.php 2010-03-01 vinaora $
* @package		VINAORA CU3ER 3D SLIDESHOW
* @copyright	Copyright (C) 2010 VINAORA and CU3ER. All rights reserved.
* @license		GNU/GPL
* @website		http://vinaora.com
* @email		admin@vinaora.com
* 
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class JElementMultiImages extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'MultiImages';

	function fetchElement($name, $value, &$node, $control_name)
	{
		jimport( 'joomla.filesystem.folder' );
		jimport( 'joomla.filesystem.file' );

		$filter = '\.png$|\.gif$|\.jpg$|\.bmp$';
		
		// path to images directory
		$path		= JPATH_ROOT.DS.$node->attributes('directory');
		$url		= $node->attributes('directory');
		
		$exclude	= $node->attributes('exclude');
		$stripExt	= $node->attributes('stripext');
		

		$files		= JFolder::files($path, $filter);

		// Construct an array of the HTML OPTION statements.
		$options = array ();

		if (!$node->attributes('hide_none'))
		{
			$options[] = JHTML::_('select.option', '-1', '- '.JText::_('Do not use').' -');
		}

		if (!$node->attributes('hide_default'))
		{
			$options[] = JHTML::_('select.option', '', '- '.JText::_('Use default').' -');
		}

		if ( is_array($files) )
		{
			foreach ($files as $file)
			{
				if ($exclude)
				{
					if (preg_match( chr( 1 ) . $exclude . chr( 1 ), $file ))
					{
						continue;
					}
				}
				if ($stripExt)
				{
					$file = JFile::stripExt( $file );
				}
				$options[] = JHTML::_('select.option', $url.'/'.$file, $file);
			}
		}
		
		// Base name of the HTML control.
		$ctrl  = $control_name .'['. $name .']';

		// Construct the various argument calls that are supported.
		$attribs       = ' ';
		if ($v = $node->attributes( 'size' )) {
				$attribs       .= 'size="'.$v.'"';
		}
		if ($v = $node->attributes( 'class' )) {
				$attribs       .= 'class="'.$v.'"';
		} else {
				$attribs       .= 'class="inputbox"';
		}
		if ($m = $node->attributes( 'multiple' ))
		{
				$attribs       .= ' multiple="multiple"';
				$ctrl          .= '[]';
		}

		// Render the HTML SELECT list.
		return JHTML::_('select.genericlist', $options, $ctrl, $attribs, 'value', 'text', $value, $control_name.$name );
	}
}
