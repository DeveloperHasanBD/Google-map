<?php

/**
 * Template name: CSV Brand Exporter
 */

csv_generator();
function csv_generator()
{
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=brand.csv');

	$brand_args = array(
		'post_type' => 'brand',
		'posts_per_page' => -1,
	);

	$brand_query = new WP_Query($brand_args);

	$output = fopen("php://output", "w");
	fputcsv($output, array('Title', 'Parent cat', 'Sub cat', 'Sub sub cat', 'Brand logo', 'Heading', 'Info one', 'Info two', 'Map link', 'Lattitude', 'Longitude'));

	if ($brand_query->have_posts()) {
		while ($brand_query->have_posts()) {
			$brand_query->the_post();
			$card_id = get_the_ID();
			$data           		=  [];
			$data['title']     		= get_the_title();
			$parent_terms 			= wp_get_post_terms($card_id, 'brand_cat', array('parent' => 0));
			$brand_terms 			= [];

			foreach ($parent_terms as $parent_single_term) {
				$sub_terms = wp_get_post_terms(get_the_ID(), 'brand_cat', array('parent' => $parent_single_term->term_id));
				foreach ($sub_terms as $sub_single_term) {
					$sub_sub_terms = wp_get_post_terms(get_the_ID(), 'brand_cat', array('parent' => $sub_single_term->term_id));
					foreach ($sub_sub_terms as $sub_sub_single_term) {
						$brand_terms[0] = $parent_single_term->name;
						$brand_terms[1] = $sub_single_term->name;
						$brand_terms[2] = $sub_sub_single_term->name;
					}
				}
			}

			$data['parent_cat']     	= $brand_terms[0] ?? '';
			$data['sub_cat']     		= $brand_terms[1] ?? '';
			$data['sub_sub_cat']     	= $brand_terms[2] ?? '';
			$data['brlf_brnd_logo'] 	= get_field('brlf_brnd_logo');
			$data['set_brnd_heading'] 	= get_field('set_brnd_heading');
			$data['brlf_brnd_info_one'] = strip_tags(get_field('brlf_brnd_info_one'));
			$data['brlf_brnd_info_two'] = get_field('brlf_brnd_info_two');
			$data['blb_go_to_map'] 		= get_field('blb_go_to_map');
			$data['set_brnd_lattitude'] = get_field('set_brnd_lattitude');
			$data['set_brnd_longitude'] = get_field('set_brnd_longitude');

			fputcsv($output, $data);
			
			// echo "<pre>";
			// print_r($data);
		}
		wp_reset_query();
	}

	fclose($output);
	exit();
}
