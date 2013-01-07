<?php
/*
PLUGIN NAME: Frontend Checklist
PLUGIN URI: http://www.j-breuer.de/wordpress-plugins/frontend-checklist/
DESCRIPTION: EN: Create HTML or PDF checklists for your visitors, which can be saved by cookie. DE: Erstelle per Cookie speicherbare HTML oder PDF Checklisten für deine Besucher.
AUTHOR: Jonas Breuer
AUTHOR URI: http://www.j-breuer.de
VERSION: 2.0.0
Min WP Version: 2.8
Max WP Version: 3.5
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

define('FRONTEND_CHECKLIST_VERSION', '2.0.0');

include_once("frontend-checklist-menu.php");


add_shortcode( 'frontend-checklist', array('Frontend_Checklist', 'output'));

//init session and cookies
add_action('plugins_loaded', array('Frontend_Checklist', 'initPlugin'));

//add js to save cookie when checking items
add_action('wp_enqueue_scripts', array('Frontend_Checklist', 'add_js'));

//check if the plugin has been updated and perform update tasks
add_action('init', array('Frontend_Checklist', 'update'));

//create tables etc. when activating
register_activation_hook(__FILE__, array('Frontend_Checklist', 'activation'));

//remove your data when uninstalling
register_uninstall_hook(__FILE__, array('Frontend_Checklist', 'uninstall'));






class Frontend_Checklist {

	
	public static function output($atts) {
		global $wpdb;
		$output = '';
		
		//get checklist from database
		if (!isset($atts['name'])) $atts['name'] = $wpdb->get_var('SELECT name from '.$wpdb->prefix.'fc_lists ORDER BY fc_listID ASC LIMIT 1');
			
		$sql = $wpdb->prepare('SELECT '.$wpdb->prefix.'fc_lists.fc_listID, text from '.$wpdb->prefix.'fc_items INNER JOIN '.$wpdb->prefix.'fc_lists USING (fc_listID) WHERE name LIKE "%s" ORDER BY fc_itemID ASC', $atts['name']);
		$items = $wpdb->get_results($sql, ARRAY_A);
			
			
		//pdf checklist
		if (isset($atts['type']) && $atts['type'] == 'pdf') {
		
			$_SESSION['frontend-checklist-items'] = $items;
			
			if (isset($atts['title']) && !empty($atts['title'])) { 
				$_SESSION['frontend-checklist-pdf-title'] = $atts['title'];
			}  else {
				$_SESSION['frontend-checklist-pdf-title'] = __('Checklist', 'frontend-checklist');
			}
		
			if (!isset($atts['linktext']) || empty($atts['linktext'])) {
				$atts['linktext'] = __('Checklist', 'frontend-checklist');
			}
			
			$output .= '<a href="'.plugins_url('frontend-checklist-pdf.php', __FILE__).'" target="_blank">';
			$output .= esc_html($atts['linktext']);
			$output .= '</a>';
		
		
		//HTML checklist
		} else {
			
			$i = 0;
			foreach ($items as $item) {
				if ($item == '') break;
				$output .= '<p><input id="frontend-checklist-'.$item['fc_listID'].'-item-'.$i.'" type="checkbox"';
				if (!isset($atts['cookie']) || $atts['cookie'] != 'off') {
					$output .= ' onchange="frontend_checklist_save_cookie('.$item['fc_listID'].')"';
					if (isset($_COOKIE['frontend-checklist-'.$item['fc_listID']])  && ($_COOKIE['frontend-checklist-'.$item['fc_listID']] & pow(2, $i)) > 0) {
						$output .= ' checked';
					}
				}
				$output .= '> '.$item['text'].'</p>';
				$i += 1;
			}
		}
		return $output;
	}
	
	public static function activation() {
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		$sql = 'CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'fc_lists (
					fc_listID int(10) unsigned NOT NULL AUTO_INCREMENT,
					name varchar(128) NOT NULL,
					description varchar(1024) NOT NULL,
					PRIMARY KEY  (fc_listID)
				);';
		dbDelta($sql);
		
		$sql = 'CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'fc_items (
					fc_itemID int(10) unsigned NOT NULL AUTO_INCREMENT,
					fc_listID int(10) unsigned NOT NULL,
					text varchar(1024) NOT NULL,
					PRIMARY KEY  (fc_itemID),
					KEY (fc_listID)
				);';
		dbDelta($sql);
	}
	
	
	
	public static function update() {
		$version = get_option('frontend-checklist-version', '0.0.0');
		if ($version != FRONTEND_CHECKLIST_VERSION) {
		
			self::activation();
			
			//updating from older version were checklist were saved as option? copy!
			$items = get_option('frontend-checklist-options');
			if (isset($items[0]) && !empty($items[0])) {
			
				global $wpdb;
			
				$wpdb->insert( 
					$wpdb->prefix.'fc_lists', 
					array( 'name' => __('Standard', 'frontend-checklist')), 
					array( '%s' ) 
				);
				$list_id = $wpdb->insert_id;
				
				
				foreach ($items as $cnt => $item) {
					if ($item == '') break;
					$text = htmlspecialchars_decode ($item, ENT_QUOTES);
					
					$wpdb->insert( 
						$wpdb->prefix.'fc_items', 
						array( 'fc_listID' => $list_id, 'text' => $text), 
						array( '%d', '%s' ) 
					);
				}
				
				//old options are not longer required
				delete_option('frontend-checklist-options');
				delete_option('frontend-checklist-count');
			}

			update_option('frontend-checklist-version', FRONTEND_CHECKLIST_VERSION);
		}
	}
	
	
	
	public static  function initPlugin() {
	
		//load language file
		$plugin_dir = basename(dirname(__FILE__));
		load_plugin_textdomain( 'frontend-checklist', '', $plugin_dir . '/languages/' );
		
		//load session for pdf-checklist
		if (!session_id()) session_start();
		
		//if the user has the old general cookie, we move it to list 1, so we have a good chance that the checklist status doesn't break when updating
		if (isset($_COOKIE['frontend_checklist'])) {
			setcookie('frontend-checklist-1', $_COOKIE['frontend_checklist'], time()+60*60*24*30*12*100, "/");
			setcookie('frontend_checklist', '', time()-100, "/");
		}
	}
	
	
	public static function add_js() {
		wp_enqueue_script('frontend-checklist', plugins_url('frontend-checklist.js', __FILE__));
	}
	
	
	static public function uninstall()  {
		global $wpdb;
		$sql = 'DROP TABLE '.$wpdb->prefix.'fc_lists;';
		$wpdb->query($sql);
		$sql = 'DROP TABLE '.$wpdb->prefix.'fc_items;';
		$wpdb->query($sql);
		
		delete_option('frontend-checklist-options');
		delete_option('frontend-checklist-count');
		delete_option('frontend-checklist-version');
	}


}


?>