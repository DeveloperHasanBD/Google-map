<?php

function lagmp_csv_custom_admin_menu()
{
	add_menu_page(
		__('CSV Expor/Emport', 'lagmap'),
		__('CSV Expor/Emport', 'lagmap'),
		'manage_options',
		'csv-exp-imp',
		'lagmp_csv_exp_imp_content'
		// 5
		// 'dashicons-location',
	);
	

}
add_action('admin_menu', 'lagmp_csv_custom_admin_menu');
