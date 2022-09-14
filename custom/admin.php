<?php
add_action( 'admin_menu', 'addiction_recovery_options_page' );
function addiction_recovery_options_page() {
    add_menu_page(
        'SEO Auto linker Ext',
        'SEO Auto linker Ext',
        'manage_options',
        'openai_integration',
        'openai_integration_page_html'
    );
}

function openai_integration_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
 
    if ( isset( $_POST['settings-updated'] ) ) {
		
		update_option( 'wpa-ext-enabled', sanitize_text_field($_POST['wpa-ext-enabled']) );
		
		if( $_POST['wpa-ext-enabled'] ) {
			addTempPosts();
		}
		
		// add settings saved message with the class of "updated"
		add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'wporg' ), 'updated' );
    }
	
	global $wpdb;
	$table_name = $wpdb->get_blog_prefix() . 'wpa_cache_temp';
	
	$posts = $wpdb->get_results("SELECT * FROM $table_name LIMIT 50000");
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		
		<h2><?php esc_html_e( 'Settings' , 'OpenAI settings');?></h2>
		
        <form action="" method="post">

			<input type="hidden" name="settings-updated" value="Y" />
		
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><?php esc_html_e( 'Enabled' , 'OpenAI settings');?></th>
						<td id="front-static-pages">
							<input type="checkbox" name="wpa-ext-enabled" id="wpa-ext-enabled"
							<?php if( get_option('wpa-ext-enabled') ) { ?> checked <?php } ?>
							value="Y" />
						</td>
					</tr>
				</tbody>
			</table>		

			<?php submit_button( 'Save Settings' ); ?>	
		
		</form>

		<p>Posts to update: <?php echo count( $posts ); ?></p>
		
		
    </div>
<?php }