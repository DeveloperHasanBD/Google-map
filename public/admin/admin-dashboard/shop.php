<?php
function lagmp_shop_content()
{
	global $wpdb;
	$lagmp_states_table = $wpdb->prefix . 'lagmp_states';
	$lagmp_countries_table = $wpdb->prefix . 'lagmp_countries';
	$lagmp_shop_details_table = $wpdb->prefix . 'lagmp_shop_details';
	$updt_shop_details_table = $wpdb->prefix . 'lagmp_shop_details';

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
	function all_country_list()
	{
		global $wpdb;
		$lagmp_countries_table = $wpdb->prefix . 'lagmp_countries';
		$all_countries 			= $wpdb->get_results("SELECT * FROM $lagmp_countries_table");
		foreach ($all_countries as $single_country) {
			$country_name = $single_country->country_name;
		?>
			<option value="<?php echo strtolower($country_name) ?>"><?php echo ucwords($country_name) ?></option>
	<?php
		}
	}
	wp_enqueue_media();

	?>

	<!-- calculation  -->
	<div class="dashboard box-border-all mt-3">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-title mt-3 shadow p-3 mb-3 bg-body rounded">
						<h2>Shop information</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<?php
					$get_up_shop_id 		= $_GET['shop_id'] ?? '';
					$updt_shop_btn 		= $_POST['updt_shop_btn'] ?? '';
					$pre_logo_path 		= $_POST['pre_logo_path'] ?? '';
					$get_logo_path 		= $_POST['logo_path'] ?? '';
					$shop_result     	= $wpdb->get_row("SELECT * FROM {$lagmp_shop_details_table} WHERE id ='{$get_up_shop_id}'");


					// $country_result     = $wpdb->get_results("SELECT * FROM {$lagmp_countries_table}");


					$final_logo = '';
					if ($pre_logo_path && $get_logo_path) {
						$final_logo 			= $get_logo_path;
					}
					if ($pre_logo_path && $get_logo_path == '') {
						$final_logo 			= $pre_logo_path;
					}

					if ('Update shop info' == $updt_shop_btn) {
						$state_name = stripslashes(sanitize_text_field($_POST['state_name']));
						$country = stripslashes(sanitize_text_field($_POST['country']));
						$lat_val = sanitize_text_field($_POST['lat_val']);
						$long_val = sanitize_text_field($_POST['long_val']);
						$shop_location = sanitize_text_field($_POST['shop_location']);
						$headline = stripslashes(sanitize_text_field($_POST['headline']));
						$adrs_line_one = stripslashes(sanitize_text_field($_POST['adrs_line_one']));
						$adrs_line_two = stripslashes(sanitize_text_field($_POST['adrs_line_two']));
						$tell = sanitize_text_field($_POST['tell']);
						$fax = sanitize_text_field($_POST['fax']);
						$website = sanitize_text_field($_POST['website']);
						$email = sanitize_text_field($_POST['email']);
						$info = stripslashes(sanitize_text_field($_POST['info']));
						$info_three = stripslashes(sanitize_text_field($_POST['info_three']));


						$wpdb->update(
							$updt_shop_details_table,
							array(
								'state_name' => $state_name,   // string
								'country' => $country,   // string
								'lat_val' => $lat_val,   // string
								'long_val' => $long_val,   // string
								'shop_location' => $shop_location,   // string
								'logo_path' => $final_logo,   // string
								'headline' => $headline,   // string
								'adrs_line_one' => $adrs_line_one,   // string
								'adrs_line_two' => $adrs_line_two,   // string
								'tell' => $tell,   // string
								'fax' => $fax,   // string
								'website' => $website,   // string
								'email' => $email,   // string
								'info' => $info,   // string
								'info_three' => $info_three,   // string
							),
							array('id' => $get_up_shop_id)
						);
					?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<strong>Successfully</strong> updated the data.
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php
					}



					$state_name 		= $shop_result->state_name ?? '';
					$country 			= $shop_result->country ?? '';
					$lat_val 			= $shop_result->lat_val ?? '';
					$long_val 			= $shop_result->long_val ?? '';
					$shop_location 		= $shop_result->shop_location ?? '';

					$logo_path 	        = $shop_result->logo_path ?? '';
					$headline 			= $shop_result->headline ?? '';
					$adrs_line_one 		= $shop_result->adrs_line_one ?? '';
					$adrs_line_two 		= $shop_result->adrs_line_two ?? '';
					$tell 				= $shop_result->tell ?? '';
					$fax 				= $shop_result->fax ?? '';
					$website 			= $shop_result->website ?? '';
					$email 				= $shop_result->email ?? '';
					$info 				= $shop_result->info ?? '';
					$info_three 		= $shop_result->info_three ?? '';




					// update state list 
					function update_shop_state_name()
					{
						global $wpdb;
						$lagmp_states_table 		= $wpdb->prefix . 'lagmp_states';
						$updt_shop_details_table 	= $wpdb->prefix . 'lagmp_shop_details';
						$get_shop_id 				= $_GET['shop_id'] ?? '';
						$states_result     			= $wpdb->get_results("SELECT * FROM {$lagmp_states_table}");
						$updt_sn_result     		= $wpdb->get_row("SELECT * FROM {$updt_shop_details_table} WHERE id ='{$get_shop_id}'");
						$updt_sn_state_name = $updt_sn_result->state_name;

						$options = '';
						foreach ($states_result as $state) {
							$selected 				= '';
							$available_state_name 	= $state->state_name;
							if (strtolower($available_state_name) == strtolower($updt_sn_state_name)) {
								$selected = 'selected';
							}
							$options .= '<option ' . $selected . ' value="' . ucwords($available_state_name) . '" >' . ucwords($available_state_name) . '</option>';
						}
						echo $options;
					}

					// update state list 
					function update_shop_countries_name()
					{
						global $wpdb;
						$lagmp_countries_table = $wpdb->prefix . 'lagmp_countries';
						$updt_shop_details_table 	= $wpdb->prefix . 'lagmp_shop_details';
						$get_shop_id 				= $_GET['shop_id'] ?? '';
						$countries_result     	    = $wpdb->get_results("SELECT * FROM {$lagmp_countries_table}");
						$updt_cn_result     		= $wpdb->get_row("SELECT * FROM {$updt_shop_details_table} WHERE id ='{$get_shop_id}'");
						$updt_cn_country_name = $updt_cn_result->country;

						$options = '';

						foreach ($countries_result as $upd_country) {
							$selected 				= '';
							echo $is_updt_country_name 	= $upd_country->country_name;
							if (strtolower($is_updt_country_name) == strtolower($updt_cn_country_name)) {
								$selected = 'selected';
							}
							$options .= '<option ' . $selected . ' value="' . ucwords($is_updt_country_name) . '" >' . ucwords($is_updt_country_name) . '</option>';
						}
						echo $options;
					}

					if ($get_up_shop_id) {
					?>
						<form action="" method="POST">
							<div class="shop_form shadow p-3 mb-5 bg-body rounded">
								<div id="shop_update_messege"></div>
								<div class="row">
									<div class="col-6">
										<div class="form-group">
											<label for="select_state_name" class="control-label">Regione</label>
											<select name="state_name" id="select_state_name" class="form-control">
												<option value="">--Select Regione--</option>
												<?php echo update_shop_state_name(); ?>
											</select>
										</div>
										<div class="form-group">
											<label for="country" class="control-label">City</label>
											<select name="country" id="country" class="form-control">
												<option value="">--Select City--</option>
												<?php update_shop_countries_name(); ?>
											</select>
										</div>
										<div class="form-group">
											<label for="shop_location" class="control-label">Shop location as CAP</label>
											<input value="<?php echo $shop_location; ?>" type="text" name="shop_location" id="shop_location" class="form-control">
										</div>
										<div class="form-group">
											<label for="lat_val" class="control-label">Latitude</label>
											<input value="<?php echo $lat_val; ?>" type="text" name="lat_val" id="lat_val" class="form-control">
										</div>
										<div class="form-group">
											<label for="long_val" class="control-label">Longitude</label>
											<input value="<?php echo $long_val; ?>" type="text" name="long_val" id="long_val" class="form-control">
										</div>
										<div class="form-group">
											<?php
											if ('Update shop info' == $updt_shop_btn) {
											?>
												<img src="<?php echo $final_logo; ?>" height="80" width="200" alt="">
												<input name="pre_logo_path" value="<?php echo $logo_path; ?>" type="hidden">
											<?php
											} else { ?>
												<img src="<?php echo $logo_path; ?>" height="80" width="200" alt="">
												<input name="pre_logo_path" value="<?php echo $logo_path; ?>" type="hidden">
											<?php
											}
											?>
											<label for="upload_logo" class="control-label">Upload logo</label>
											<p class="text-center">
												<span id="show_logo_image"></span>
											</p>
											<input name="logo_path" id="logo_url" type="hidden">
											<input type="button" id="upload_logo" value="Upload Ad" class="form-control">
										</div>
										<div class="form-group">
											<label for="headline" class="control-label">Headline</label>
											<input value="<?php echo $headline; ?>" type="text" name="headline" id="headline" class="form-control">
										</div>
										<div class="form-group">
											<label for="adrs_line_one" class="control-label">Address line #1</label>
											<input value="<?php echo $adrs_line_one; ?>" type="text" name="adrs_line_one" id="adrs_line_one" class="form-control">
										</div>
										<div class="form-group">
											<label for="adrs_line_two" class="control-label">Address line #2</label>
											<input value="<?php echo $adrs_line_two; ?>" type="text" name="adrs_line_two" id="adrs_line_two" class="form-control">
										</div>
									</div>
									<div class="col-6">

										<div class="form-group">
											<label for="tell" class="control-label">Tell</label>
											<input value="<?php echo $tell; ?>" type="text" name="tell" id="tell" class="form-control">
										</div>
										<div class="form-group">
											<label for="fax" class="control-label">Fax</label>
											<input value="<?php echo $fax; ?>" type="text" name="fax" id="fax" class="form-control">
										</div>

										<div class="form-group">
											<label for="email" class="control-label">Email</label>
											<input value="<?php echo $email; ?>" type="text" name="email" id="email" class="form-control">
										</div>
										<div class="form-group">
											<label for="info" class="control-label">Info #1</label>
											<input value="<?php echo $info; ?>" type="text" name="info" id="info" class="form-control">
										</div>
										<div class="form-group">
											<label for="info_three" class="control-label">Info #2</label>
											<input value="<?php echo $info_three; ?>" type="text" name="info_three" id="info_three" class="form-control">
										</div>
										<div class="form-group">
											<label for="website" class="control-label">Map url</label>
											<input value="<?php echo $website; ?>" type="text" name="website" id="website" class="form-control">
										</div>
										<input type="submit" name="updt_shop_btn" value="Update shop info" class="btn btn-primary mt-2">

									</div>
								</div>
							</div>
				</div>
				</form>
			<?php
					} else {
			?>
				<form id="shop_form" action="" method="POST">
					<div class="shop_form shadow p-3 mb-5 bg-body rounded">
						<div id="shop_data_messege"></div>
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<label for="select_state_name" class="control-label">Regione</label>
									<select name="state_name" id="select_state_name" class="get_cntry_as_con form-control">
										<option value="">--Select Regione--</option>
										<?php echo all_stats_list(); ?>
									</select>
								</div>
								<div class="display_cntry_list">
									<div class="form-group">
										<label for="country" class="control-label">City</label>
										<select name="country" id="country" class="get_country_as_lat_lng form-control">
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="shop_location" class="control-label">Shop location as CAP</label>
									<input type="text" name="main_shop_location" id="shop_location" class="form-control">
								</div>

								<div class="set_lt_long_value">

								</div>

								<div class="form-group">
									<label for="upload_logo" class="control-label">Upload logo</label>
									<p class="text-center">
										<span id="show_logo_image"></span>
									</p>
									<input type="button" id="upload_logo" value="Upload Ad" class="form-control">
									<input name="logo_path" id="logo_url" type="hidden">
								</div>
								<div class="form-group">
									<label for="headline" class="control-label">Headline</label>
									<input type="text" name="headline" id="headline" class="form-control">
								</div>
								<div class="form-group">
									<label for="adrs_line_one" class="control-label">Address line #1</label>
									<input type="text" name="adrs_line_one" id="adrs_line_one" class="form-control">
								</div>
								<div class="form-group">
									<label for="adrs_line_two" class="control-label">Address line #2</label>
									<input type="text" name="adrs_line_two" id="adrs_line_two" class="form-control">
								</div>

							</div>

							<div class="col-6">
								<div class="form-group">
									<label for="tell" class="control-label">Tell</label>
									<input type="text" name="tell" id="tell" class="form-control">
								</div>
								<div class="form-group">
									<label for="fax" class="control-label">Fax</label>
									<input type="text" name="fax" id="fax" class="form-control">
								</div>
								<div class="form-group">
									<label for="email" class="control-label">Email</label>
									<input type="text" name="email" id="email" class="form-control">
								</div>
								<div class="form-group">
									<label for="info" class="control-label">Info #1</label>
									<input type="text" name="info" id="info" class="form-control">
								</div>
								<div class="form-group">
									<label for="info_three" class="control-label">Info #2</label>
									<input type="text" name="info_three" id="info_three" class="form-control">
								</div>
								<div class="form-group">
									<label for="website" class="control-label">Map url</label>
									<input type="text" name="website" id="website" class="form-control">
								</div>
								<input type="submit" name="shop_btn" class="btn btn-primary mt-2">
							</div>
						</div>
					</div>
			</div>
			</form>
		<?php
					}
		?>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="shop_list">
					<?php
					$delete_shop_did 	= $_POST['delete_shop_did'] ?? '';
					$delete_shop_dtl 	= $_POST['delete_shop_dtl'] ?? '';
					if ('Delete shop' == $delete_shop_dtl) {
						$wpdb->delete($updt_shop_details_table, array('id' => $delete_shop_did));
					?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<strong>Successfully</strong> deleted the data.
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php
					}
					?>
					<table class="table" id="shop_list_table">
						<thead>
							<tr>
								<th scope="col">State name</th>
								<th scope="col">Country name</th>
								<th scope="col">Shop location</th>
								<th scope="col">Latitude</th>
								<th scope="col">Longitude</th>
								<th scope="col">Logo</th>
								<th scope="col">Headline</th>
								<th scope="col">Address line #1</th>
								<th scope="col">Address line #2</th>
								<th scope="col">Tell</th>
								<th scope="col">Fax</th>
								<th scope="col">Email</th>
								<th scope="col">Info #1</th>
								<th scope="col">Info#2</th>
								<th scope="col">Map url</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>

							<?php
							$all_countries    = $wpdb->get_results("SELECT * FROM $lagmp_shop_details_table");
							foreach ($all_countries as $sc_country) {
								$shop_id = $sc_country->id;
							?>
								<tr>
									<td><?php echo $sc_country->state_name; ?></td>
									<td><?php echo $sc_country->country; ?></td>
									<td><?php echo $sc_country->shop_location; ?></td>
									<td><?php echo $sc_country->lat_val; ?></td>
									<td><?php echo $sc_country->long_val; ?></td>
									<td>
										<?php
										$logo_path = $sc_country->logo_path;
										if ($logo_path) {
										?>
											<div class="shoplg_logo_size">
												<img src="<?php echo $logo_path ?>" alt="">
											</div>
										<?php
										}
										?>
									</td>
									<td><?php echo $sc_country->headline; ?></td>
									<td><?php echo $sc_country->adrs_line_one; ?></td>
									<td><?php echo $sc_country->adrs_line_two; ?></td>
									<td><?php echo $sc_country->tell; ?></td>
									<td><?php echo $sc_country->fax; ?></td>
									<td><?php echo $sc_country->email; ?></td>
									<td><?php echo $sc_country->info; ?></td>
									<td><?php echo $sc_country->info_three; ?></td>
									<td><?php echo $sc_country->website; ?></td>
									<td>
										<div class="action_btn_dgn">
											<a href="<?php echo admin_url("admin.php?page=shop&shop_id=$shop_id"); ?>" class="btn btn-warning">Update</a>
											<form action="" method="POST">
												<input type="hidden" name="delete_shop_did" value="<?php echo $shop_id; ?>">
												<input name="delete_shop_dtl" class="btn btn-danger" type="submit" value="Delete shop" onclick="return confirm('Are you sure want to delete ?')">
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