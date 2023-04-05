<?php
function lagmp_dashboard_content()
{
	global $wpdb;
	$user_id = '';
	if (is_user_logged_in()) {
		$user_id = get_current_user_id();
	}
	$lagmp_states_table = $wpdb->prefix . 'lagmp_states';
	$lagmp_countries_table = $wpdb->prefix . 'lagmp_countries';
	$lagmp_api_table = $wpdb->prefix . 'lagmp_api';
	$get_state_id = $_GET['state_id'] ?? '';
	if ($get_state_id) {
		$state_result     = $wpdb->get_row("SELECT * FROM {$lagmp_states_table} WHERE id ='{$get_state_id}'");
		$update_state_name = $state_result->state_name;
	}

	// states list 
	function all_stats_list()
	{
		global $wpdb;
		$lagmp_states_table = $wpdb->prefix . 'lagmp_states';

		$all_states = $wpdb->get_results("SELECT * FROM $lagmp_states_table");
		foreach ($all_states as $state) {
			$state_name = $state->state_name;
?>
			<option value="<?php echo strtolower($state_name) ?>"><?php echo ucwords($state_name) ?></option>
	<?php
		}
	}
	// start country 



	wp_enqueue_media();

	?>


	<div class="mt-3 shadow p-3 mb-3 bg-body rounded user-dashboard">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-title mt-3 shadow p-3 mb-3 bg-body rounded">
						<h2>Welcome to GMAP Dashboard!</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-4">
					<div class="api_form shadow p-3 mb-5 bg-body rounded">
						<?php
						$lamp_api_btn = $_POST['lamp_api_btn'] ?? '';
						$api_result     	= $wpdb->get_results("SELECT * FROM {$lagmp_api_table}");
						$count_api = count($api_result);
						if ($count_api == 0) {
							$api_data = [
								'lamp_api'    => 'AIzaSyBJzGjTWgaMhydsoGwjpu-EVxnqKX1bt4w',
							];
							$wpdb->insert($lagmp_api_table, $api_data);
						}
						if ($count_api == 1) {
							if ('Update API Key' == $lamp_api_btn) {
								$get_api_id = '';
								foreach ($api_result as $api_id) {
									$get_api_id = $api_id->id;
								}
								$lamp_api = sanitize_text_field($_POST['lamp_api']);
								$wpdb->update(
									$lagmp_api_table,
									array(
										'lamp_api' => $lamp_api,   // string
									),
									array('id' => $get_api_id)
								);
						?>
								<div class="alert alert-success alert-dismissible fade show" role="alert">
									<strong>Successfully</strong> updated the API Key.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
						<?php
							}
						}
						$is_api = '';
						foreach ($api_result as $api_id) {
							$is_api = $api_id->lamp_api;
						}
						?>
						<form action="" method="POST">
							<label for="lamp_api">API Key</label>
							<input id="lamp_api" type="text" name="lamp_api" value="<?php echo $is_api ? $is_api : ''; ?>" class="form-control">
							<input type="submit" name="lamp_api_btn" value="Update API Key" class="btn btn-primary mt-2">
						</form>
					</div>
				</div>
				<div class="col-8">
					<div class="state_list_table shadow p-3 mb-5 bg-body rounded">
						<h2>This plugins provided shortcode:</h2>
						<p>If you want to use this shortcode in any php file, please use like this</p>
							<quote>
								<div>
									<div>&lt;?php do_shortcode('[custom_gmap]');?&gt;</div>
								</div>
							</quote>
							<p class="mt-4">If you want to use this shortcode in any WordPress page, please use like this</p>
							<quote>
								<div>
									<div>[custom_gmap]</div>
								</div>
							</quote>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end top  -->


<?php
}
?>