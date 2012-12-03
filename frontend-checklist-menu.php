<?php

add_action('admin_init', array('Frontend_Checklist_Menu', 'adminInit'));
add_action('admin_menu', array('Frontend_Checklist_Menu', 'adminMenu'));



class Frontend_Checklist_Menu {

	static protected $checklist_count = 0;

	
	static public function adminInit() {
	
		$total_count = get_option('frontend-checklist-count');
		if (!is_numeric($total_count) || $total_count < 1 || $total_count > 50) {
			update_option('frontend-checklist-count', 20);
			$total_count = 20;
		}
	
		register_setting( 'frontend-checklist-options', 'frontend-checklist-count', array('Frontend_Checklist_Menu', 'countValidate') );
		register_setting( 'frontend-checklist-options', 'frontend-checklist-options', array('Frontend_Checklist_Menu', 'optionsValidate') );
		
		add_settings_section('frontend-checklist-count-section', '', array('Frontend_Checklist_Menu', 'dummy'), 'frontend-checklist-options');
		add_settings_section('frontend-checklist-main-section', __('To-Dos', 'frontend-checklist'), array('Frontend_Checklist_Menu', 'dummy'), 'frontend-checklist-options');
		
		
		add_settings_field('frontend-checklist-count-field', __('Number of To-Dos (max.50)', 'frontend-checklist'), array('Frontend_Checklist_Menu', 'CountField'), 'frontend-checklist-options', 'frontend-checklist-count-section');
		
		for ($i=1;$i<=$total_count;$i++) {
			add_settings_field('frontend-checklist-to-do-'.$i, $i.'. ', array('Frontend_Checklist_Menu', 'ToDoField'), 'frontend-checklist-options', 'frontend-checklist-main-section');
		}
		
		

	}

	static public function adminMenu() {
		add_options_page('Frontend Checklist', __('Frontend Checklist', 'frontend-checklist'), 'manage_options', 'frontend-checklist', array('Frontend_Checklist_Menu', 'optionsPage'));
	}
	
	static public function dummy() {
		//no more output required, this is just a dummy callback for the add_settings_section()
	}
	
	
	static public function optionsPage() {
		?>
		<div class="wrap">
		<h2><?php _e('Frontend Checklist', 'frontend-checklist'); ?></h2>
		<p><?php _e('Welcome to Frontend Checklist. Just enter the number of To-Dos in the first field. Write the To-Dos into the other fields without leaving a field blank. You can also use HTML, if you want.', 'frontend-checklist'); ?></p>
		<p><?php _e('To output the HTML checklist, just enter <code>[frontend-checklist]</code> into the editor at any place.<br />If you don\'t want that the status of the checklist is saved via cookie, you can use this code: <code>[frontend-checklist cookie=\"off\"]</code><br />Link to the PDF-Checklist: <code>[frontend-checklist type="pdf" title="My Checklist" linktext="To the Checklist"]</code>. The Title is the headline in the PDF file.', 'frontend-checklist'); ?></p>
		<p><?php _e('If you like the plugin and if you have a blog where it suits, I would appreciate a presentation of the plugin. You can find more about the plugin and my work as a web developer on  <a href="http://www.j-breuer.de/blog/" target="_blank">my blog (German)</a>. I always appreciate ideas about how to improve the plugin.', 'frontend-checklist'); ?></p>
		
		<form action="options.php" method="post">
		<?php settings_fields('frontend-checklist-options'); ?>
		<?php do_settings_sections('frontend-checklist-options'); ?>
		<p><input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" /></p>
		</form>
		
		</div>
		<?php
	}
	
	
	static public function CountField() {
		$default_value = get_option('frontend-checklist-count');
		echo '<input type="text" name="frontend-checklist-count" size="60" value="'.$default_value.'" />';
	}
	

	static public function ToDoField() {
		$options = get_option('frontend-checklist-options');
		
		if (isset($options[self::$checklist_count])) $default_value = $options[self::$checklist_count];
		else $default_value = '';
		
		echo '<input type="text" name="frontend-checklist-options[]" size="60" value="'.$default_value.'" />';
		self::$checklist_count += 1;
	}
	
	
	
	
	
	
	
	//Validation
	static public function countValidate($input) {
		$int_input = (int)$input;
		if ($int_input < 1) $int_input = 20;
		if ($int_input > 50) $int_input = 50;
		return $int_input;
	}
	
	
	static public function optionsValidate($input) {
	
		foreach ($input as $cnt => $todo) {
			if ($todo != '') {
				$whitelist[$cnt] = esc_html($todo);
			}
		}
		return $whitelist;
	}
	
	
	
}
?>