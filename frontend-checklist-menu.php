<?php

add_action('admin_menu', array('Frontend_Checklist_Menu', 'adminMenu'));



class Frontend_Checklist_Menu {
	
	

	static public function adminMenu() {
		add_options_page('Frontend Checklist', __('Frontend Checklist', 'frontend-checklist'), 'manage_options', 'frontend-checklist', array('Frontend_Checklist_Menu', 'adminPage'));
	}
	

	
	//controller function for all admin actions
	static public function adminPage() {
	
		if (!isset($_GET['action'])) $_GET['action'] = '';
	
		switch ($_GET['action']) {
				
			case 'new':
				self::newPage();
				break;
			
			case 'new_perform':
				self::newPerform();
				self::overviewPage();
				break;
			
			case 'edit':
				if (is_numeric($_GET['id'])) self::editPage();
				break;
				
			case 'edit_perform':
				if (is_numeric($_GET['id'])) self::editPerform();
				self::overviewPage();
				break;
				
			//delete has no page, I just show a JS confirm box
				
			case 'delete_perform':
				if (is_numeric($_GET['id'])) self::deletePerform();
				self::overviewPage();
				break;
			
			default:
				self::overviewPage();
		
		}
		
	}

	
	//explanations and overview over all checklists
	static public function overviewPage() {
	
		global $wpdb;
		
		$sql = 'SELECT fc_listID, name, description FROM '.$wpdb->prefix.'fc_lists ORDER BY fc_listID ASC';
		$lists = $wpdb->get_results($sql, ARRAY_A);
		
		?>
		<div class="wrap">
		<h2><?php _e('Frontend Checklist', 'frontend-checklist'); ?></h2>
		<p><?php _e('Welcome to Frontend Checklist. Just click New Checklist or Edit on an existing checklist to manage your checklists', 'frontend-checklist'); ?></p>
		<p><?php _e('To output a HTML checklist, just enter <code>[frontend-checklist name="Standard"]</code> (replace the name attribute for other checklist names) into the editor at any place.', 'frontend-checklist'); ?></p>
		<p><?php _e('If you don\'t want that the status of the checklist is saved via cookie, you can use this code: <code>[frontend-checklist name="Standard" cookie="off"]</code> If cookies are off, the plugin will save the status of the checklist for logged in users in the database.', 'frontend-checklist'); ?></p>
		<p><?php _e('To control the cookie lifetime, use the days attribute: <code>[frontend-checklist name="Standard" days="180"]</code> (default is 365 days)', 'frontend-checklist'); ?></p>
		<p><?php _e('Link to the PDF-Checklist: <code>[frontend-checklist name="Standard" type="pdf" title="My Checklist" linktext="To the Checklist"]</code>. The Title is the headline in the PDF file.', 'frontend-checklist'); ?></p>
		<p><?php _e('If you like the plugin and if you have a blog where it suits, I would appreciate a presentation of the plugin. You can find more about the plugin and my work as a web developer on  <a href="http://www.j-breuer.de/blog/" target="_blank">my blog (German)</a>. I always appreciate ideas about how to improve the plugin.', 'frontend-checklist'); ?></p>
		<?php if (defined('WPLANG') && WPLANG == 'de_DE') echo '<p>Wenn du Geld als Affiliate verdienst, ist vielleicht auch mein Plugin <a href="http://www.j-breuer.de/wordpress-plugins/affiliate-power/?utm_campaign=frontend_checklist" target="_blank">Affiliate Power</a> für dich interessant.</p>'; ?>
		<p><a href="options-general.php?page=frontend-checklist&action=new"><strong><?php _e('New Checklist', 'frontend-checklist'); ?></strong></a></p>
		
		<table class="widefat fixed" cellspacing="0">
			<thead>
				<tr>
					<th><?php _e('Name', 'frontend-checklist'); ?></th>
					<th><?php _e('Description', 'frontend-checklist'); ?></th>
					<th><?php _e('Syntax', 'frontend-checklist'); ?></th>
					<th><?php _e('Actions', 'frontend-checklist'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th><?php _e('Name', 'frontend-checklist'); ?></th>
					<th><?php _e('Description', 'frontend-checklist'); ?></th>
					<th><?php _e('Syntax', 'frontend-checklist'); ?></th>
					<th><?php _e('Actions', 'frontend-checklist'); ?></th>
				</tr>
			</tfoot>
			<?php foreach($lists as $list): 
				$delete_href = wp_nonce_url('options-general.php?page=frontend-checklist&action=delete_perform&id='.$list['fc_listID'], 'frontent-checklist-delete');
				$delete_onclick = 'if (confirm(&quot;'.__('Do you really want to delete the checklist %s?', 'frontend-checklist').'&quot;)) return true; else return false';
				?>
				<tr>
					<td><a href="options-general.php?page=frontend-checklist&action=edit&id=<?php echo $list['fc_listID']; ?>"><?php print esc_html($list['name']); ?></a></td>
					<td><?php print esc_html($list['description']); ?></td>
					<td>[frontend-checklist name="<?php print $list['name'] ?>"]</td>
					<td><a href="options-general.php?page=frontend-checklist&action=edit&id=<?php echo $list['fc_listID']; ?>"><?php _e('Edit', 'frontend-checklist'); ?></a> | <a href="<?php echo $delete_href; ?>" onclick="<?php printf($delete_onclick, esc_html($list['name'])); ?>"><?php _e('Delete', 'frontend-checklist'); ?></a></td>
				</tr>
			<?php endforeach ?>
		</table>
		
		</div>
		<?php
	}
	
	
	static public function newPage() {
	
		?>
		
		<div class="wrap">
			<form method="post" action="options-general.php?page=frontend-checklist&action=new_perform">
				<?php wp_nonce_field('frontend-checklist-new'); ?>
				
				<h3><?php _e('List settings', 'frontend-checklist'); ?></h3>
				<table class="form-table"><tbody>
					<tr valign="top"><th scope="row"><?php _e('Name', 'frontend-checklist');?></th><td><input type="text" name="name" size="20"></td></tr>
					<tr valign="top"><th scope="row"><?php _e('Description', 'frontend-checklist');?></th><td><input type="text" name="description" size="60"></td></tr>
				</tbody></table>
				
				<h3><?php _e('Items', 'frontend-checklist'); ?></h3>
				<p><?php _e('Just enter a number of items (up to 50) without leaving any fields blank. New fields will appear automatically. You can use HTML.', 'frontend-checklist'); ?></p>
				<table class="form-table"><tbody>
					<?php 
					for ($i=0; $i<50; $i++) { 
						if ($i >= 10) $style = 'display:none;';
						else $style = 'display:block;';
						?>
						<tr valign="top" id="fc-item-<?php echo $i; ?>" style="<?php echo $style; ?>"><th scope="row"><?php echo ($i+1) ?>.</th><td><input type="text" name="items[]" size="80" onfocus="document.getElementById('fc-item-<?php echo $i+1; ?>').style.display='block';"></td></tr>
						<?php 
					} ?>
				</tbody></table>
				
				<input type="submit" name="edit_perform" value="<?php _e('Save Changes', 'frontend-checklist'); ?>">
			</form>		
		</div>
		<?php
	}
	
	
	static public function newPerform() {
	
		global $wpdb;
		check_admin_referer('frontend-checklist-new');
		
		if (!isset($_POST['name']) || empty($_POST['name'])) $_POST['name'] = __('unnamed', 'frontend-checklist');
		
		$wpdb->insert (
			$wpdb->prefix.'fc_lists',
			array('name' => $_POST['name'], 'description' => $_POST['description']),
			array('%s', '%s')
		);
		
		$list_id = $wpdb->insert_id;
		
		foreach($_POST['items']  as $item) {
			if ($item != '') {
			
				$item = stripslashes($item);
			
				$wpdb->insert(
					$wpdb->prefix.'fc_items',
					array( 'fc_listID' => $list_id, 'text' => $item), 
					array( '%d', '%s' ) 
				);	
				
			}
		}	
		
	}
	
	
	
	
	static public function editPage() {
	
		global $wpdb;
		$sql = $wpdb->prepare('SELECT fc_listID, name, description FROM '.$wpdb->prefix.'fc_lists WHERE fc_listID = %d', $_GET['id']);
		$list = $wpdb->get_row($sql, ARRAY_A);
		$sql = $wpdb->prepare('SELECT text FROM '.$wpdb->prefix.'fc_items WHERE fc_listID = %d ORDER BY fc_itemID asc', $_GET['id']);
		$items = $wpdb->get_results($sql, ARRAY_A);
		?>
		
		<div class="wrap">
			<form method="post" action="options-general.php?page=frontend-checklist&action=edit_perform&id=<?php echo $_GET['id'];?>">
				<?php wp_nonce_field('frontend-checklist-edit'); ?>
				
				<h3><?php _e('List settings', 'frontend-checklist'); ?></h3>
				<table class="form-table"><tbody>
					<tr valign="top"><th scope="row"><?php _e('Name', 'frontend-checklist');?></th><td><input type="text" name="name" size="20" value="<?php echo esc_html($list['name']); ?>"></td></tr>
					<tr valign="top"><th scope="row"><?php _e('Description', 'frontend-checklist');?></th><td><input type="text" name="description" size="60" value="<?php echo esc_html($list['description']); ?>"></td></tr>
				</tbody></table>
				
				<h3><?php _e('Items', 'frontend-checklist'); ?></h3>
				<p><?php _e('Just enter a number of items (up to 50) without leaving any fields blank. New fields will appear automatically. You can use HTML.', 'frontend-checklist'); ?></p>
				<table class="form-table"><tbody>
					<?php 
					$style_next = 'display:block;';
					for ($i=0; $i<50; $i++) { 
					
						if (!isset($items[$i]['text'])) $items[$i]['text'] = '';
						?>
						<tr valign="top" style="<?php echo $style_next; ?>" id="fc-item-<?php echo $i; ?>"><th scope="row"><?php echo ($i+1) ?>.</th><td><input type="text" name="items[]" size="80" value="<?php echo esc_html($items[$i]['text']); ?>" onfocus="document.getElementById('fc-item-<?php echo $i+1; ?>').style.display='block';"></td></tr>
						<?php 
						//only show one empty field
						if (empty($items[$i]['text'])) $style_next = 'display:none;';
						
					} ?>
				</tbody></table>
				
				<input type="submit" name="edit_perform" value="<?php _e('Save Changes', 'frontend-checklist'); ?>">
			</form>		
		</div>
		<?php
	}
	
	
	static public function editPerform() {
	
		global $wpdb;
		check_admin_referer('frontend-checklist-edit');
		
		if (!isset($_POST['name']) || empty($_POST['name'])) $_POST['name'] = __('unnamed', 'frontend-checklist');
		
		$wpdb->update (
			$wpdb->prefix.'fc_lists',
			array('name' => $_POST['name'], 'description' => $_POST['description']),
			array('fc_listID' => $_GET['id']),
			array('%s', '%s'),
			array('%d')
		);
		
		$sql = $wpdb->prepare('DELETE FROM '.$wpdb->prefix.'fc_items WHERE fc_listID = %d', $_GET['id']);
		$wpdb->query($sql);
		
		foreach($_POST['items']  as $item) {
			if ($item != '') {
			
				$item = stripslashes($item);
			
				$wpdb->insert(
					$wpdb->prefix.'fc_items',
					array( 'fc_listID' => $_GET['id'], 'text' => $item), 
					array( '%d', '%s' ) 
				);	
				
			}
		}	
		
	}
	
	
	static public function deletePerform() {
	
		global $wpdb;
		check_admin_referer('frontent-checklist-delete');
				
		$sql = $wpdb->prepare('DELETE FROM '.$wpdb->prefix.'fc_lists WHERE fc_listID = %d LIMIT 1', $_GET['id']);
		$wpdb->query($sql);
		
		$sql = $wpdb->prepare('DELETE FROM '.$wpdb->prefix.'fc_items WHERE fc_listID = %d', $_GET['id']);
		$wpdb->query($sql);
	}
	
	
}
?>