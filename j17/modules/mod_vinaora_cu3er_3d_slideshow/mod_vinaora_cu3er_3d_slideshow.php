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


$msg = modAbcdefHelper::getTest();
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_abcdef', $params->get('layout', 'default'));