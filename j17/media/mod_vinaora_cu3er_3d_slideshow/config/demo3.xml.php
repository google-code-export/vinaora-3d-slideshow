<?php
/**
 * @version		$Id: demo3.xml.php 2011-07-20 vinaora $
 * @package		Vinaora Cu3er 3D Slideshow
 * @subpackage	mod_vinaora_cu3er_3d_slideshow
 * @copyright	Copyright (C) 2010 - 2011 VINAORA. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @website		http://vinaora.com
 * @twitter		http://twitter.com/vinaora
 * @facebook	http://facebook.com/vinaora
 */
 
$script		= $_SERVER['SCRIPT_NAME'];
$base_path	= substr($script, 0 , strpos($script, 'config/'));
header ("content-type: text/xml");
header ("Cache-Control: max-age=86400, must-revalidate");
?>
<cu3er>
	<settings>
		<general slide_panel_width="600" slide_panel_height="300" />
		<prev_button>
			<defaults round_corners="5,5,5,5"/>
			<tweenOver tint="0xFFFFFF" scaleX="1.1" scaleY="1.1"/>
			<tweenOut tint="0x000000" />
		</prev_button>
		<prev_symbol>
			<tweenOver tint="0x000000" />
		</prev_symbol>
		<next_button>
			<defaults round_corners="5,5,5,5"/>
			<tweenOver tint="0xFFFFFF"  scaleX="1.1" scaleY="1.1"/>
			<tweenOut tint="0x000000" />
		</next_button>
		<next_symbol>
			<tweenOver tint="0x000000" />
		</next_symbol>
	</settings>
	<slides>
		<slide>
			<url><?php echo $base_path; ?>images/demo3/slide_1.jpg</url>
			<description>
				<link target="_blank">http://vinaora.com</link>
				<heading>Vinaora Cu3er 3D Slideshow</heading>
				<paragraph>Paragraph text - put your text here and describe your beautiful slide. Paragraph text - put your text here and describe your beautiful slide. Paragraph text - put your text here and describe your beautiful slide.</paragraph>
			</description>
		</slide>
		<!-- changing transition between first & second slide -->
		<transition num="3" slicing="vertical" direction="down"/>
		<slide>
			<url><?php echo $base_path; ?>images/demo3/slide_2.jpg</url>
		</slide>
		<!-- changing transition between second & third slide -->
		<transition num="4" direction="right" shader="flat" />
		<slide>
			<url><?php echo $base_path; ?>images/demo3/slide_3.jpg</url>
		</slide>
		<!-- transitions properties defined in transitions template -->
		<slide>
			<url><?php echo $base_path; ?>images/demo3/slide_4.jpg</url>
		</slide>
		<transition num="6" slicing="vertical" direction="up" shader="flat" delay="0.05" z_multiplier="4" />
		<slide>
			<url><?php echo $base_path; ?>images/demo3/slide_5.jpg</url>
		</slide>
	</slides>
</cu3er>
