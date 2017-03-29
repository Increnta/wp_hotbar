<?php
/**
 * Plugin Name: Hot Bar
 * Plugin URI: https://github.com/Increnta/wp_hotbar/
 * Description: Add top bar with text and button on website.
 * Author: Alberto González - Increnta
 * Version: 1.0
 *
 */
if (!defined('ABSPATH')) die('-1');

class INCHotBar {

    function __construct() {
		add_action('theme_after_body_tag_start', array( $this, 'inc_front_hotbar') );		
		
		add_action( 'admin_menu', array( $this, 'inc_admin_hotbar_menu') );

    }
	public function inc_add_scripts_hotbar() {
		
		wp_register_style('hotbar_css', plugins_url('assets/css/style.css',__FILE__ ));
		wp_enqueue_style('hotbar_css');
		
		wp_register_script( 'hotbar_js', plugins_url('assets/js/custom.js',__FILE__ ));
		wp_enqueue_script('hotbar_js');
		
	}
	
	public function inc_front_hotbar(){
		$active = 0;
		$active = (int)get_option( 'hotbar_active' );
		if($active){
			$this->inc_add_scripts_hotbar();
			$button_url		=	get_option( 'hotbar_button_url' );
			$button_text	=	get_option( 'hotbar_button_text' );
			$description 	=	get_option( 'hotbar_description' );
			
			echo '
				<div class="topBar">
					<div class="wrapTopBar">' . $description . '<a href="' . $button_url . '" class="buttonTopBar">' . $button_text . '</a></div>
					<span class="closeTopBar">x</span>
				</div>
			';
		}
	
	}
	public function inc_admin_hotbar_menu() {
		add_menu_page( __('Hot Bar Preferences','hotbar'), __('Hot Bar','horbar'), 'manage_options', 'hotbar-view', array($this,'inc_admin_hotbar') );
	}
 
	public function inc_hotbar_admin_notice($message, $class = 'error') {
	  echo '<div class="' . $class . ' fade' . '"><p>'. $message . '</p></div>';
	}
	
	public function inc_admin_hotbar() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		if ( isset( $_POST['hotbar_save_nonce'] ) && wp_verify_nonce( $_POST['hotbar_save_nonce'], 'hotbar_save' ) ) {
			if( 
				!empty($_POST["hotbar_description"]) && 
				!empty($_POST["hotbar_button_text"]) && 
				!empty($_POST["hotbar_button_url"])				
			){
				update_option( 'hotbar_active', intval($_POST["hotbar_active"]) );
				update_option( 'hotbar_description', wp_strip_all_tags($_POST["hotbar_description"], true) );
				update_option( 'hotbar_button_text', wp_strip_all_tags($_POST["hotbar_button_text"], true) );
				update_option( 'hotbar_button_url', wp_strip_all_tags($_POST["hotbar_button_url"], true) );
	
	           $this->inc_hotbar_admin_notice(__("Updated successfully!","hotbar"), 'updated');
			}else{
	           $this->inc_hotbar_admin_notice(__("An error has occurred.","hotbar"));
			}
	 		
		}


		$active = (int)get_option( 'hotbar_active' );
		$button_url		=	get_option( 'hotbar_button_url' );
		$button_text	=	get_option( 'hotbar_button_text' );
		$description 	=	get_option( 'hotbar_description' );
		echo '<div class="wrap">';
		?>
		<form action="<?=admin_url( 'admin.php?page=hotbar-view' ); ?>" method="post">
		<h3><?php _e('Hot Bar Settings','hotbar'); ?></h3>
		<table class="form-table">
		    <tbody>
				<tr>
				    <th scope="row"><?php _e('Enable','hotbar'); ?></th>
				    <td>
				        <fieldset>
				            <label for="hotbar_active">
				                <input type="checkbox" <?php if($active) print 'checked="checked"'; ?> value="1" id="hotbar_active" name="hotbar_active"> <?php _e('Active hot bar','hotbar'); ?>
				            </label>
				
				        </fieldset>
				    </td>
				</tr>
				<tr>
				    <th scope="row">
				        <label for="hotbar_description"><?php _e('Description','hotbar'); ?></label>
				    </th>
				 
				    <td>
				        <input type="text" value="<?=$description; ?>" name="hotbar_description">
		 		    </td>
				</tr>
				<tr>
				    <th scope="row">
				        <label for="hotbar_button_text"><?php _e('Button text','hotbar'); ?></label>
				    </th>
				 
				    <td>
				        <input type="text" value="<?=$button_text; ?>" name="hotbar_button_text">
		 		    </td>
				</tr>
				<tr>
				    <th scope="row">
				        <label for="hotbar_button_url"><?php _e('Button link','hotbar'); ?></label>
				    </th>
				 
				    <td>
				        <input type="text" value="<?=$button_url; ?>" name="hotbar_button_url">
		 		    </td>
				</tr>
		    </tbody>
		</table>
		<?php print wp_nonce_field( 'hotbar_save', 'hotbar_save_nonce' );  ?>
		<p class="submit"><input type="submit" value="Save Changes" class="button-primary" name="Submit"></p>
		</form>
		<?php
		echo '</div>';
	}
}


$incHotBar = new INCHotBar();