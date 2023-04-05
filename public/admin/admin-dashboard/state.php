<?php
function lagmp_state_content()
{
	global $wpdb;
	$lagmp_states_table = $wpdb->prefix . 'lagmp_states';
	$get_state_id = $_GET['regione_id'] ?? '';
	if ($get_state_id) {
		$state_result     	= $wpdb->get_row("SELECT * FROM {$lagmp_states_table} WHERE id ='{$get_state_id}'");
		$update_state_name 	= $state_result->state_name ?? '';
		$update_state_lat 	= $state_result->state_lat ?? '';
		$update_state_long 	= $state_result->state_long ?? '';
	}
?>
	<!-- calculation  -->
	<div class="dashboard box-border-all mt-3">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-title mt-3 shadow p-3 mb-3 bg-body rounded">
						<h2>Regione information</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-4">
					<div class="state_form shadow p-3 mb-5 bg-body rounded">
						<div id="state_messege"></div>
						<?php
						$update_state_btn = $_POST['update_state_btn'] ?? '';
						if ('Update State' == $update_state_btn) {
							$state_name = stripslashes(sanitize_text_field($_POST['state_name']));
							$state_lat = sanitize_text_field($_POST['state_lat']);
							$state_long = sanitize_text_field($_POST['state_long']);
							$state_lat_n_long = $state_lat . '|' . $state_long;
							$wpdb->update(
								$lagmp_states_table,
								array(
									'state_name' => $state_name,   // string
									'state_lat' => $state_lat,   // string
									'state_long' => $state_long,   // string
									'state_lat_n_long' => $state_lat_n_long,   // string
								),
								array('id' => $get_state_id)
							);
						?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<strong>Successfully</strong> updated the data.
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						<?php
						}
						if ($get_state_id) {
						?>
							<div class="state_update_form">
								<form action="" method="POST">
									<label for="state_name">Regione name</label>
									<input id="state_name" value="<?php echo $get_state_id ? $update_state_name : ''; ?>" type="text" name="state_name" class="form-control">



									<label for="state_lat">Regione lat</label>
									<input value="<?php echo $get_state_id ? $update_state_lat : ''; ?>" id="state_lat" type="text" name="state_lat" class="form-control">

									<label for="state_long">Regione long</label>
									<input value="<?php echo $get_state_id ? $update_state_long : ''; ?>" id="state_long" type="text" name="state_long" class="form-control">

									<input type="submit" name="update_state_btn" value="Update State" class="btn btn-primary mt-2">

									<a class="btn btn-info mt-2" href="<?php echo admin_url("admin.php?page=state"); ?>">Add more state ?</a>
								</form>
							</div>
						<?php
						} else {
						?>
							<form id="state_form" action="" method="POST">

								<label for="state_name">Regione name</label>
								<input id="state_name" type="text" name="state_name" class="form-control">


								<label for="state_lat">Regione lat</label>
								<input id="state_lat" type="text" name="state_lat" class="form-control">


								<label for="state_long">Regione long</label>
								<input id="state_long" type="text" name="state_long" class="form-control">


								<input type="submit" name="state_btn" class="btn btn-primary mt-2">
							</form>
						<?php
						}
						?>
					</div>
				</div>
				<div class="col-8">
					<div class="state_list_table shadow p-3 mb-5 bg-body rounded">
						<?php
						$delete_state_did 	= $_POST['delete_state_did'] ?? '';
						$delete_state_name 	= $_POST['delete_state_name'] ?? '';
						if ('Delete state' == $delete_state_name) {
							$wpdb->delete($lagmp_states_table, array('id' => $delete_state_did));
						?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<strong>Successfully</strong> deleted the data.
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						<?php
						}
						?>
						<table class="table" id="state_list_table">
							<thead>
								<tr>
									<th scope="col">Regione name</th>
									<th scope="col">Regione lat</th>
									<th scope="col">Regione long</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$lagmp_states_results = $wpdb->get_results("SELECT * FROM $lagmp_states_table");
								foreach ($lagmp_states_results as $state_name) {
									$state_id = $state_name->id;
								?>
									<tr>
										<td><?php echo ucwords($state_name->state_name); ?></td>
										<td><?php echo ucwords($state_name->state_lat); ?></td>
										<td><?php echo ucwords($state_name->state_long); ?></td>
										<td class="action_btn_dgn">
											<a href="<?php echo admin_url("admin.php?page=regione&regione_id=$state_id"); ?>" class="btn btn-warning">Update</a>
											<form action="" method="POST">
												<input type="hidden" name="delete_state_did" value="<?php echo $state_id; ?>">
												<input name="delete_state_name" class="btn btn-danger" type="submit" value="Delete state" onclick="return confirm('Are you sure want to delete ?')">
											</form>
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