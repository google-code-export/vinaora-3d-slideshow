<?php
/**
* @version		$Id: default.php 2010-04-20 vinaora $
* @package		VINAORA VISITORS COUNTER
* @copyright	Copyright (C) 2010 VINAORA and CU3ER. All rights reserved.
* @license		GNU/GPL
* @website		http://vinaora.com
* @email		admin@vinaora.com
* 
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<!-- BEGIN: VINAORA 3D SLIDE SHOW -->
<!-- Website http://vinaora.com -->
<script type="text/javascript">
	var flashvars = {};
	flashvars.xml = "<?php echo $config_path; ?>";
	flashvars.font = "<?php echo $font_path; ?>";
	var attributes = {};
	attributes.wmode = "transparent";
	attributes.id = "slider<?php echo $module_id; ?>";
	swfobject.embedSWF(<?php echo "\"$slideshow_path\", \"$container\", \"$width\", \"$height\", \"$flash_version\", \"$expressInstall_path\""; ?>, flashvars, attributes);
</script>
<div id="<?php echo $container; ?>" class="v3dslideshow<?php echo $moduleclass_sfx; ?>">
    <a href="http://www.adobe.com/go/getflashplayer">
        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
    </a>
	<a href="http://vinaora.com">Joomla! Guides, Joomla Tutorials and Templates</a>
</div>
<!-- Website http://vinaora.com -->
<!-- END: VINAORA 3D SLIDE SHOW -->