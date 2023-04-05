<?php

/**
 * Plugin Name:       lagmap
 * Plugin URI:        https://www.red-apple.it/
 * Description:       GMAP
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Red Apple International
 * Author URI:        https://www.red-apple.it/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       lagmap
 * Domain Path:       /languages
 */

define('LAGMP_TEMPLATE_PATH', plugin_dir_path(__FILE__));

// Assets link enqueue 
require_once(LAGMP_TEMPLATE_PATH . 'public/enqueue.php');

// acf cpt 
 require_once(LAGMP_TEMPLATE_PATH . 'public/inc/acf-cpt.php');
 
// functionality 
require_once(LAGMP_TEMPLATE_PATH . 'public/admin/functionality/ajax-data-processing-lg-map.php');
require_once(LAGMP_TEMPLATE_PATH . 'public/admin/admin-menu/admin-menu.php');
require_once(LAGMP_TEMPLATE_PATH . 'public/admin/pages/csv-exp-imp.php');
require_once(LAGMP_TEMPLATE_PATH . 'public/admin/functionality/csv-import-processing.php');


function lagmp_front_end_view_new()
{
    require_once(LAGMP_TEMPLATE_PATH . 'public/users/new-map-view.php');
}
add_shortcode('custom_gmap', 'lagmp_front_end_view_new');

// function lagmap_db_table_generate()
// {
//     require_once(LAGMP_TEMPLATE_PATH . 'public/inc/db-table.php');
// }
// register_activation_hook(__FILE__, 'lagmap_db_table_generate');

// start get_bricolife_brand_locations  
function get_bricolife_brand_locations()
{
    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $terms_table = $table_prefix . 'terms';
    $term_taxonomy_table = $table_prefix . 'term_taxonomy';
    $taxonomy_name = 'brand_cat';
    $get_term_ids = $wpdb->get_results("SELECT * FROM {$term_taxonomy_table} WHERE taxonomy = '{$taxonomy_name}' AND parent=0 AND count !=0");
    $total_term_ids = count($get_term_ids);
    $get_the_term_ids = [];
    for ($i = 0; $i < $total_term_ids; $i++) {
        $get_the_term_ids[] .= $get_term_ids[$i]->term_id;
    }
    $count_all_term_ids = count($get_the_term_ids);
?>
    <option value="" selected disabled>PAESE</option>
    <?php
    for ($i = 0; $i < $count_all_term_ids; $i++) {
        $mcq_cat_slug_name = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE term_id = $get_the_term_ids[$i]");
        $mcq_cat_name = $mcq_cat_slug_name->name;
        $mcq_cat_slug = $mcq_cat_slug_name->slug;
    ?>
        <option value="<?php echo $mcq_cat_slug; ?>"><?php echo $mcq_cat_name; ?></option>
<?php
    }
}






/**
 * 
 * start csv exporter file 
 * 
 */
   global $wpdb;
$post_table = $wpdb->prefix . 'posts';
$is_exist_csv_ex_page = $wpdb->get_row("SELECT * FROM $post_table WHERE post_type = 'page' AND post_status='publish' AND post_name='csv-brand-expoter'");

if ($is_exist_csv_ex_page) {
} else {
    $csv_exporter_page = [];
    $csv_exporter_page['post_title']    = 'CSV Brand Exporter';
    $csv_exporter_page['post_status']   = 'publish';
    $csv_exporter_page['post_name']     = 'csv-brand-expoter';
    $csv_exporter_page['post_type']     = 'page';
    wp_insert_post($csv_exporter_page);
}


/**
 * 
 * End csv state exporter file 
 * 
 */


// function brand_csv_exporter_page_template()
// {
//     global $post;
//     if ($post->post_name == 'csv-brand-expoter') {
//         require_once(LAGMP_TEMPLATE_PATH . 'public/admin/pages/csv-brand-exporter.php');
//         die;
//     }
// }
// add_filter('page_template', 'brand_csv_exporter_page_template');