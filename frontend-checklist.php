<?php
/*
PLUGIN NAME: Frontend Checklist
PLUGIN URI: http://www.j-breuer.de/wordpress-plugins/frontend-checklist/
DESCRIPTION: Mit Frontend Checklist kannst du eine HTML- oder PDF-Checkliste für deine Besucher erzeugen. Der Status der HTML-Checkliste kann per Cookie gespeichert werden. So können deine Besucher jedezeit zurückkehren und die Checkliste weiter abhaken.
AUTHOR: Jonas Breuer
AUTHOR URI: http://www.j-breuer.de
VERSION: 1.0.0
Min WP Version: 2.8
Max WP Version: 3.4.2
License: GPL3
*/


/* Copyright 2012 Jonas Breuer (email : kontakt@j-breuer.de)
 
This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 3, as
 published by the Free Software Foundation.
 
This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/


include_once("frontend-checklist-menu.php");


add_shortcode( 'frontend-checklist', array('Frontend_Checklist', 'output'));
add_action('plugins_loaded', array('Frontend_Checklist', 'init'));
add_action('wp_enqueue_scripts', array('Frontend_Checklist', 'add_js'));
register_uninstall_hook(__FILE__, array('Frontend_Checklist', 'uninstall'));





class Frontend_Checklist {

	
	public static function output($atts) {
		$output = '';
		$options = get_option('frontend-checklist-options');
		
		if (isset($atts['type']) && $atts['type'] == 'pdf') {
			$_SESSION['frontend-checklist-options'] = $options;
			
			if (isset($atts['title']) && !empty($atts['title'])) { 
				$_SESSION['frontend-checklist-pdf-title'] = $atts['title'];
			}  else {
				$_SESSION['frontend-checklist-pdf-title'] = 'Checkliste';
			}
		
			if (!isset($atts['linktext']) || empty($atts['linktext'])) {
				$atts['linktext'] = 'Checkliste';
			}
			
			$output .= '<a href="'.plugins_url('frontend-checklist-pdf.php', __FILE__).'" target="_blank">';
			$output .= esc_html($atts['linktext']);
			$output .= '</a>';
		} else {
			foreach ($options as $cnt => $option) {
				if ($option == '') break;
				$output .= '<p><input id="frontend-checklist-todo-'.$cnt.'" type="checkbox"';
				if (!isset($atts['cookie']) || $atts['cookie'] != 'off') {
					$output .= ' onchange="frontend_checklist_save_cookie()"';
					if (isset($_COOKIE['frontend_checklist'])  && ($_COOKIE['frontend_checklist'] & pow(2, $cnt)) > 0) {
						$output .= ' checked';
					}
				}
				$output .= '> '.htmlspecialchars_decode ($option, ENT_QUOTES).'</p>';
			}
		}
		return $output;
	}
	
	
	
	public static  function init() {
		$plugin_dir = basename(dirname(__FILE__));
		load_plugin_textdomain( 'frontend-checklist', '', $plugin_dir . '/languages/' );
	}
	
	
	public static function add_js() {
		wp_enqueue_script('frontend-checklist', plugins_url('frontend-checklist.js', __FILE__));
	}
	
	
	static public function uninstall()  {
		delete_option('frontend-checklist-options');
		delete_option('frontend-checklist-count');
	}


}


?>