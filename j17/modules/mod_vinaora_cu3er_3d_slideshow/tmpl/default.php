<?php
/**
 * @version		$Id: default.php 2011-07-21 vinaora $
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
?>
<!-- BEGIN: VINAORA CU3ER 3D SLIDE SHOW -->
<!-- Website http://vinaora.com -->
<script type="text/javascript">
	var flashvars = {};
	flashvars.xml = "<?php echo $config_name; ?>";
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
	<br />
	<a href="http://vinaora.com/">Free Joomla Templates, extensions &amp; tutorials</a>
</div>
<!-- Website http://vinaora.com -->
<!-- END: VINAORA CU3ER 3D SLIDE SHOW -->
