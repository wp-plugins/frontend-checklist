<?php

add_action('admin_init', array('Frontend_Checklist_Menu', 'adminInit'));
add_action('admin_menu', array('Frontend_Checklist_Menu', 'adminMenu'));



class Frontend_Checklist_Menu {

	static protected $checklist_count = 0;

	
	static public function adminInit() {
		register_setting( 'frontend-checklist-options', 'frontend-checklist-options', array('Frontend_Checklist_Menu', 'optionsValidate') );
		
		add_settings_section('frontend-checklist-main', 'To-Dos', array('Frontend_Checklist_Menu', 'optionsMainText'), 'frontend-checklist-options');
		
		for ($i=1;$i<=20;$i++) {
			add_settings_field('frontend-checklist-to-do-'.$i, $i.'. ', array('Frontend_Checklist_Menu', 'ToDoField'), 'frontend-checklist-options', 'frontend-checklist-main');
		}

	}

	static public function adminMenu() {
		add_options_page('Frontend Checklist', 'Frontend Checklist', 'manage_options', 'frontend-checklist', array('Frontend_Checklist_Menu', 'optionsPage'));
	}
	
	
	static public function optionsPage() {
		?>
		<div class="wrap">
		<h2>Frontend Checklist</h2>
		<p>Herzlich Willkommen zu Frontend Checklist! Füge einfach eine beliebige Anzahl an ToDos untereinander ein, ohne Lücken zu lassen. Du kannst auch HTML verwenden.</p>
		<p>Zum Ausgeben der HTML Checkliste einfach den Tag <code>[frontend-checklist]</code> im Editor an der gewünschten Stelle eingeben.<br />
		Sollen die abgehakten ToDos nicht gespeichert werden, kann dieser Code benutzt werden: <code>[frontend-checklist cookie="off"]</code><br />
		Link auf eine PDF-Checkliste: <code>[frontend-checklist type="pdf" title="Meine Checkliste" linktext="Zur Checkliste"]</code>. Der Title erscheint in der PDF-Datei als Überschrift.
		<p>Sollte dir das Plugin gefallen und du einen Blog haben, wo es thematisch passt, würde ich mich über eine Vorstellung des Plugins sehr freuen. Mehr Infos zum Plugin und zu meiner Arbeit als Webentwickler gibt es auf <a href="http://www.j-breuer.de/blog/" target="_blank">meinem Blog</a>. Ich freue mich jederzeit über Vorschläge zur Verbesserung des Plugins.</p>
		
		<form action="options.php" method="post">
		<?php settings_fields('frontend-checklist-options'); ?>
		<?php do_settings_sections('frontend-checklist-options'); ?>
		<p><input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" /></p>
		</form>
		
		</div>
		<?php
	}
	

	static public function ToDoField() {
		$options = get_option('frontend-checklist-options');
		echo '<input type="text" name="frontend-checklist-options[]" size="60" value="'.$options[self::$checklist_count].'" />';
		self::$checklist_count += 1;
	}
	
	
	
	
	
	//Validation
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