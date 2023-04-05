<?php
function lagmp_country_content()
{
	global $wpdb;
	$lagmp_states_table 	= $wpdb->prefix . 'lagmp_states';
	$lagmp_countries_table  = $wpdb->prefix . 'lagmp_countries';
	$country_id = $_GET['city_id'] ?? '';
	if ($country_id) {
		$country_result     	= $wpdb->get_row("SELECT * FROM {$lagmp_countries_table} WHERE id ='{$country_id}'");
		$update_country_name 	= $country_result->country_name ?? '';
		$country_lat 	= $country_result->country_lat ?? '';
		$country_lng 	= $country_result->country_lng ?? '';
	}
	// states list 
	function all_stats_list()
	{
		global $wpdb;
		$lagmp_states_table = $wpdb->prefix . 'lagmp_states';
		$all_states 		= $wpdb->get_results("SELECT * FROM $lagmp_states_table");
		foreach ($all_states as $state) {
			$state_name = $state->state_name;
?>
			<option value="<?php echo strtolower($state_name) ?>"><?php echo ucwords($state_name) ?></option>
	<?php
		}
	}
	// update state list 
	function update_state_name()
	{
		global $wpdb;
		$lagmp_states_table 	= $wpdb->prefix . 'lagmp_states';

		$lagmp_countries_table 		= $wpdb->prefix . 'lagmp_countries';
		$country_slted_id 			= $_GET['city_id'] ?? '';
		$update_state 				= $wpdb->get_results("SELECT * FROM $lagmp_states_table");
		$ss_result     				= $wpdb->get_row("SELECT * FROM {$lagmp_countries_table} WHERE id ='{$country_slted_id}'");
		$ss_update_state_name 		= $ss_result->state_name;

		$options = '';
		foreach ($update_state as $state) {
			$selected 				= '';
			$available_state_name 	= $state->state_name;
			if (strtolower($available_state_name) == strtolower($ss_update_state_name)) {
				$selected = 'selected';
			}
			$options .= '<option ' . $selected . ' value="' . ucwords($available_state_name) . '" >' . ucwords($available_state_name) . '</option>';
		}
		echo $options;
	}

	?>
	<!-- calculation  -->
	<div class="dashboard box-border-all mt-3">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-title mt-3 shadow p-3 mb-3 bg-body rounded">
						<h2>City information</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-4">
					<div class="country_form shadow p-3 mb-5 bg-body rounded">
						<div id="country_messege"></div>

						<?php

						//  start Update country 
						$update_country_btn = $_POST['update_country_btn'] ?? '';
						if ('Update city' == $update_country_btn) {
							$upd_country_name = stripslashes(sanitize_text_field($_POST['country_name']));
							$country_lat = sanitize_text_field($_POST['country_lat']);
							$country_lng = sanitize_text_field($_POST['country_lng']);
							$upd_select_state_name = stripslashes(sanitize_text_field($_POST['select_state_name']));
							$wpdb->update(
								$lagmp_countries_table,
								array(
									'state_name' => $upd_select_state_name,   // string
									'country_name' => $upd_country_name,   // string
									'country_lat' => $country_lat,   // string
									'country_lng' => $country_lng,   // string
								),
								array('id' => $country_id)
							);
						?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<strong>Successfully</strong> updated the data.
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						<?php
						}
						if ($country_id) {
						?>
							<form action="" method="POST">


								<label for="country_name">City name</label>
								<input id="country_name" value="<?php echo $update_country_name; ?>" type="text" name="country_name" class="form-control">


								<label for="country_lat">City lat</label>
								<input value="<?php echo $country_lat; ?>" id="country_lat" type="text" name="country_lat" class="mb-3 form-control">

								<label for="country_lng">City lng</label>
								<input value="<?php echo $country_lng; ?>" id="country_lng" type="text" name="country_lng" class="mb-3 form-control">

								<select name="select_state_name" id="select_countries_name" class="form-control mt-3">
									<option value="">-- Select Regione --</option>
									<?php update_state_name(); ?>
								</select>
								<input type="submit" name="update_country_btn" value="Update city" class="btn btn-primary mt-2">
								<a class="btn btn-info mt-2" href="<?php echo admin_url("admin.php?page=country"); ?>">Add more City ?</a>
							</form>
						<?php
						} else {
						?>
							<form id="country_form" action="" method="POST">

								<label for="country_name">City name</label>
								<input id="country_name" type="text" name="country_name" class="mb-3 form-control">

								<label for="country_lat">City lat</label>
								<input id="country_lat" type="text" name="country_lat" class="mb-3 form-control">

								<label for="country_lng">City lng</label>
								<input id="country_lng" type="text" name="country_lng" class="mb-3 form-control">

								<select name="select_state_name" id="select_countries_name" class="form-control">
									<option value="">-- Select regione --</option>
									<?php all_stats_list(); ?>
								</select>
								<input type="submit" name="country_btn" class="btn btn-primary mt-2">
							</form>
						<?php
						}
						?>
					</div>
				</div>
				<div class="col-8">
					<div class="state_list_table shadow p-3 mb-5 bg-body rounded">

						<?php
						$delete_country_did = $_POST['delete_country_did'] ?? '';
						$delete_country_name = $_POST['delete_country_name'] ?? '';

						if ('Delete City' == $delete_country_name) {
							$wpdb->delete($lagmp_countries_table, array('id' => $delete_country_did));
						?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<strong>Successfully</strong> deleted the data.
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						<?php
						}
						?>


						<table class="table" id="country_list_table">
							<thead>
								<tr>
									<th scope="col">Regione name</th>
									<th scope="col">City name</th>
									<th scope="col">City lat</th>
									<th scope="col">City lng</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$lagmp_countries_results = $wpdb->get_results("SELECT * FROM $lagmp_countries_table");
								foreach ($lagmp_countries_results as $country) {
									$country_id 	= $country->id;
									$c_state_name 	= $country->state_name;
									$country_name 	= $country->country_name;
									$country_lat 	= $country->country_lat;
									$country_lng 	= $country->country_lng;
								?>
									<tr>
										<td><?php echo ucwords($c_state_name); ?></td>
										<td><?php echo ucwords($country_name); ?></td>
										<td><?php echo ucwords($country_lat); ?></td>
										<td><?php echo ucwords($country_lng); ?></td>
										<td>
											<div class="action_btn_dgn">
												<a href="<?php echo admin_url("admin.php?page=city&city_id=$country_id"); ?>" class="btn btn-warning">Update</a>
												<form action="" method="POST">
													<input type="hidden" name="delete_country_did" value="<?php echo $country_id; ?>">
													<input name="delete_country_name" class="btn btn-danger" type="submit" value="Delete City" onclick="return confirm('Are you sure want to delete ?')">
												</form>
											</div>

										</td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end state list  -->

<?php
}
?>