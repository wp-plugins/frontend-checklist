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
		
		
		add_settings_field('frontend-checklist-count-field', __('Anzahl To-Dos (max. 50)', 'frontend-checklist'), array('Frontend_Checklist_Menu', 'CountField'), 'frontend-checklist-options', 'frontend-checklist-count-section');
		
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
		<p><?php _e('Herzlich Willkommen zu Frontend Checklist! Gib einfach im ersten Feld die gewünschte Anzahl an To-Dos an. Schreib dann die  ToDos untereinander in die Felder, ohne Lücken zu lassen. Du kannst auch HTML verwenden.', 'frontend-checklist'); ?></p>
		<p><?php _e('Zum Ausgeben der HTML Checkliste einfach den Tag <code>[frontend-checklist]</code> im Editor an der gewünschten Stelle eingeben.<br />Sollen die abgehakten ToDos nicht gespeichert werden, kann dieser Code benutzt werden: <code>[frontend-checklist cookie="off"]</code><br />Link auf eine PDF-Checkliste: <code>[frontend-checklist type="pdf" title="Meine Checkliste" linktext="Zur Checkliste"]</code>. Der Title erscheint in der PDF-Datei als Überschrift.', 'frontend-checklist'); ?></p>
		<p><?php _e('Sollte dir das Plugin gefallen und du einen Blog haben, wo es thematisch passt, würde ich mich über eine Vorstellung des Plugins sehr freuen. Mehr Infos zum Plugin und zu meiner Arbeit als Webentwickler gibt es auf <a href="http://www.j-breuer.de/blog/" target="_blank">meinem Blog</a>. Ich freue mich jederzeit über Vorschläge zur Verbesserung des Plugins.', 'frontend-checklist'); ?></p>
		
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