<?php



function set_brand_locations()
{
    $param                 = sanitize_text_field($_POST['param']);
    $get_location                 = $_POST['get_location'];
    global $wpdb;
    $lagmp_states_table = $wpdb->prefix . 'lagmp_states';

    $brands_array = [];
    $table_prefix = $wpdb->prefix;
    $terms_table = $table_prefix . 'terms';
    $term_taxonomy_table = $table_prefix . 'term_taxonomy';

    $get_term_id = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE slug= '{$get_location}'");
    $get_single_ter_id = $get_term_id->term_id;

    $get_term_ids = $wpdb->get_results("SELECT * FROM {$term_taxonomy_table} WHERE parent= '{$get_single_ter_id}'");

    $total_term_ids = count($get_term_ids);
    $get_the_term_ids = [];
    for ($i = 0; $i < $total_term_ids; $i++) {
        $get_the_term_ids[] .= $get_term_ids[$i]->term_id;
    }

    $total_term_reg_ids = count($get_the_term_ids);

    $get_term_names = [];
    $get_term_slugs = [];
    for ($i = 0; $i < $total_term_reg_ids; $i++) {
        $get_term_name = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE term_id = $get_the_term_ids[$i]");
        $get_term_names[] = $get_term_name->name;
        $get_term_slugs[] = $get_term_name->slug;
    }
    if ('location' == $param) {
        $args = array(
            'post_type' => 'brand',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $get_location,
                ),
            ),
        );
        $location_query = new WP_Query($args);
        $html = '<option value="">REGIONE</option>';
        $count_regions = count($get_term_names);
        for ($i = 0; $i < $count_regions; $i++) {
            $html .= '<option value=' . " $get_term_slugs[$i]" . '>' . ucwords($get_term_names[$i]) . '</option>';
        }

        $i = 0;
        while ($location_query->have_posts()) {
            $location_query->the_post();

            $brlf_brnd_logo = get_field('brlf_brnd_logo');
            $set_brnd_heading = get_field('set_brnd_heading');
            $brlf_brnd_info_one = get_field('brlf_brnd_info_one');
            $brlf_brnd_info_two = get_field('brlf_brnd_info_two');
            $blb_go_to_map = get_field('blb_go_to_map');
            $set_brnd_lattitude = get_field('set_brnd_lattitude');
            $set_brnd_longitude = get_field('set_brnd_longitude');


            $brands_array['brnd_ln_long'][$i]['logo'] = $brlf_brnd_logo;
            $brands_array['brnd_ln_long'][$i]['set_brnd_heading'] = $set_brnd_heading;
            $brands_array['brnd_ln_long'][$i]['brlf_brnd_info_one'] = $brlf_brnd_info_one;
            $brands_array['brnd_ln_long'][$i]['brlf_brnd_info_two'] = $brlf_brnd_info_two;
            $brands_array['brnd_ln_long'][$i]['blb_go_to_map'] = $blb_go_to_map;
            $brands_array['brnd_ln_long'][$i]['latitude'] = $set_brnd_lattitude;
            $brands_array['brnd_ln_long'][$i]['longitude'] = $set_brnd_longitude;

            $i++;
        }
        wp_reset_query();
    }

    $brands_array['regions_name'] = $html;
    echo json_encode($brands_array);
    die;
}
add_action('wp_ajax_brand_locations', 'set_brand_locations');
add_action('wp_ajax_nopriv_brand_locations', 'set_brand_locations');

function lg_select_region_data()
{
    global $wpdb;
    $lg_param                 = sanitize_text_field($_POST['param']);
    $set_region                 = sanitize_text_field($_POST['set_region']);
    $regions_array = [];

    if ('lg_region' == $lg_param) {
        $table_prefix = $wpdb->prefix;
        $terms_table = $table_prefix . 'terms';
        $term_taxonomy_table = $table_prefix . 'term_taxonomy';
        $get_term_id = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE slug= '{$set_region}'");
        $get_single_ter_id = $get_term_id->term_id;

        $get_term_ids = $wpdb->get_results("SELECT * FROM {$term_taxonomy_table} WHERE parent= '{$get_single_ter_id}'");

        $tparent_term_id = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE slug= '{$set_region}'");
        $child_term_id = $tparent_term_id->term_id;

        $get_p_term_id = $wpdb->get_row("SELECT * FROM {$term_taxonomy_table} WHERE term_id= $child_term_id");
        $tparent_single_term = $get_p_term_id->parent;

        $get_mp_term_id = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE term_id= $tparent_single_term");
        $get_main_pname = $get_mp_term_id->slug;

        $total_term_ids = count($get_term_ids);
        $get_the_term_ids = [];
        for ($i = 0; $i < $total_term_ids; $i++) {
            $get_the_term_ids[] .= $get_term_ids[$i]->term_id;
        }
        $total_term_reg_ids = count($get_the_term_ids);
        $get_term_names = [];
        $get_term_prnt_slugs = [];
        for ($i = 0; $i < $total_term_reg_ids; $i++) {
            $get_term_name = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE term_id = $get_the_term_ids[$i]");
            $get_term_names[] = $get_term_name->name;
            $get_term_prnt_slugs[] = $get_term_name->slug;
        }

        $args = array(
            'post_type' => 'brand',
            'posts_per_page' => -1,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $set_region,
                ),
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $get_main_pname,
                ),
            ),
        );
        $regions_query = new WP_Query($args);
        $html = '<option value="">Città</option>';
        $count_regions = count($get_term_names);
        for ($i = 0; $i < $count_regions; $i++) {
            $html .= '<option value=' . " $get_term_prnt_slugs[$i]" . '>' . ucwords($get_term_names[$i]) . '</option>';
        }

        $i = 0;
        while ($regions_query->have_posts()) {
            $regions_query->the_post();

            $brlf_brnd_logo = get_field('brlf_brnd_logo');
            $set_brnd_heading = get_field('set_brnd_heading');
            $brlf_brnd_info_one = get_field('brlf_brnd_info_one');
            $brlf_brnd_info_two = get_field('brlf_brnd_info_two');
            $blb_go_to_map = get_field('blb_go_to_map');
            $set_brnd_lattitude = get_field('set_brnd_lattitude');
            $set_brnd_longitude = get_field('set_brnd_longitude');

            $regions_array['reg_ln_long'][$i]['logo'] = $brlf_brnd_logo;
            $regions_array['reg_ln_long'][$i]['set_brnd_heading'] = $set_brnd_heading;
            $regions_array['reg_ln_long'][$i]['brlf_brnd_info_one'] = $brlf_brnd_info_one;
            $regions_array['reg_ln_long'][$i]['brlf_brnd_info_two'] = $brlf_brnd_info_two;
            $regions_array['reg_ln_long'][$i]['blb_go_to_map'] = $blb_go_to_map;
            $regions_array['reg_ln_long'][$i]['latitude'] = $set_brnd_lattitude;
            $regions_array['reg_ln_long'][$i]['longitude'] = $set_brnd_longitude;

            $i++;
        }
        wp_reset_query();
        $regions_array['html'] = $html;
        echo json_encode($regions_array);
    }
    die;
}
add_action('wp_ajax_lg_select_region', 'lg_select_region_data');
add_action('wp_ajax_nopriv_lg_select_region', 'lg_select_region_data');


function lg_country_city_data()
{
    global $wpdb;
    $lg_param                 = sanitize_text_field($_POST['param']);
    $set_city                 = sanitize_text_field($_POST['set_city']);
    $city_array = [];

    if ('lg_city' == $lg_param) {

        $table_prefix = $wpdb->prefix;
        $terms_table = $table_prefix . 'terms';
        $term_taxonomy_table = $table_prefix . 'term_taxonomy';

        $get_term_id = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE slug= '{$set_city}'");
        $get_single_ter_id = $get_term_id->term_id;


        $get_term_ids = $wpdb->get_results("SELECT * FROM {$term_taxonomy_table} WHERE parent= '{$get_single_ter_id}'");


        // echo "sdsd TTT";

        $get_p_term_id = $wpdb->get_row("SELECT * FROM {$term_taxonomy_table} WHERE term_id= $get_single_ter_id");
        $tparent_single_term = $get_p_term_id->parent;

        // 2rd parent id 
        $get_mp_term_id = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE term_id= $tparent_single_term");
        $get_main_pname = $get_mp_term_id->slug;
        $get_main_pid = $get_mp_term_id->term_id;

        // 3rd parent id 
        $get_3rdmp_term_id = $wpdb->get_row("SELECT * FROM {$term_taxonomy_table} WHERE term_id= $get_main_pid");
        $get_3rd_pid = $get_3rdmp_term_id->parent;

        $get_3rd_term_id = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE term_id= $get_3rd_pid");
        $get_3rd_slug = $get_3rd_term_id->slug;

        $total_term_ids = count($get_term_ids);
        $get_the_term_ids = [];
        for ($i = 0; $i < $total_term_ids; $i++) {
            $get_the_term_ids[] .= $get_term_ids[$i]->term_id;
        }

        $total_term_reg_ids = count($get_the_term_ids);

        $get_term_names = [];
        $get_term_prnt_slugs = [];
        for ($i = 0; $i < $total_term_reg_ids; $i++) {
            $get_term_name = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE term_id = $get_the_term_ids[$i]");
            $get_term_names[] = $get_term_name->name;
            $get_term_prnt_slugs[] = $get_term_name->slug;
        }

        $args = array(
            'post_type' => 'brand',
            'posts_per_page' => -1,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $set_city,
                ),
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $get_main_pname,
                ),
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $get_3rd_slug,
                ),
            ),
        );
        $regions_query = new WP_Query($args);

        $html = '<option value="">CODICE POSTALE</option>';
        $count_regions = count($get_term_names);
        for ($i = 0; $i < $count_regions; $i++) {
            $html .= '<option value=' . " $get_term_prnt_slugs[$i]" . '>' . ucwords($get_term_names[$i]) . '</option>';
        }

        $i = 0;
        while ($regions_query->have_posts()) {
            $regions_query->the_post();

            $brlf_brnd_logo = get_field('brlf_brnd_logo');
            $set_brnd_heading = get_field('set_brnd_heading');
            $brlf_brnd_info_one = get_field('brlf_brnd_info_one');
            $brlf_brnd_info_two = get_field('brlf_brnd_info_two');
            $blb_go_to_map = get_field('blb_go_to_map');
            $set_brnd_lattitude = get_field('set_brnd_lattitude');
            $set_brnd_longitude = get_field('set_brnd_longitude');

            $city_array['city_ln_long'][$i]['logo'] = $brlf_brnd_logo;
            $city_array['city_ln_long'][$i]['set_brnd_heading'] = $set_brnd_heading;
            $city_array['city_ln_long'][$i]['brlf_brnd_info_one'] = $brlf_brnd_info_one;
            $city_array['city_ln_long'][$i]['brlf_brnd_info_two'] = $brlf_brnd_info_two;
            $city_array['city_ln_long'][$i]['blb_go_to_map'] = $blb_go_to_map;
            $city_array['city_ln_long'][$i]['latitude'] = $set_brnd_lattitude;
            $city_array['city_ln_long'][$i]['longitude'] = $set_brnd_longitude;

            $i++;
        }
        wp_reset_query();


        $city_array['html'] = $html;
        echo json_encode($city_array);
    }
    die;
}
add_action('wp_ajax_lg_country_city', 'lg_country_city_data');
add_action('wp_ajax_nopriv_lg_country_city', 'lg_country_city_data');


function lg_city_zip_data()
{
    global $wpdb;
    $lg_param                 = sanitize_text_field($_POST['param']);
    $set_zip                 = sanitize_text_field($_POST['set_zip']);
    $city_array = [];

    if ('lg_zip' == $lg_param) {



        $table_prefix = $wpdb->prefix;
        $terms_table = $table_prefix . 'terms';
        $term_taxonomy_table = $table_prefix . 'term_taxonomy';
        $taxonomy_name = 'brand_cat';



        $get_term_id = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE slug= '{$set_zip}'");
        $get_single_ter_id = $get_term_id->term_id;
        // die;

        $get_p_term_id = $wpdb->get_row("SELECT * FROM {$term_taxonomy_table} WHERE term_id= $get_single_ter_id");
        $tparent_single_term = $get_p_term_id->parent;
        // die;
        // 2rd parent id 
        $get_mp_term_id = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE term_id= $tparent_single_term");
        $get_main_pname = $get_mp_term_id->slug;
        $get_main_pid = $get_mp_term_id->term_id;

        // 3rd parent id 
        $get_3rdmp_term_id = $wpdb->get_row("SELECT * FROM {$term_taxonomy_table} WHERE term_id= $get_main_pid");
        $get_3rd_pid = $get_3rdmp_term_id->parent;

        $get_3rd_term_id = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE term_id= $get_3rd_pid");
        $get_3rd_slug = $get_3rd_term_id->slug;
        $get_3rd_id = $get_3rd_term_id->term_id;


        // 4th parent 

        $get_4rdmp_term_id = $wpdb->get_row("SELECT * FROM {$term_taxonomy_table} WHERE term_id= $get_3rd_id");
        $get_4rd_pid = $get_4rdmp_term_id->parent;

        $get_4rd_term_id = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE term_id= $get_4rd_pid");
        $get_4rd_slug = $get_4rd_term_id->slug;

        $args = array(
            'post_type' => 'brand',
            'posts_per_page' => -1,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $set_zip,
                ),
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $get_main_pname,
                ),
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $get_3rd_slug,
                ),
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $get_4rd_slug,
                ),
            ),
        );
        $regions_query = new WP_Query($args);


        $i = 0;
        while ($regions_query->have_posts()) {
            $regions_query->the_post();

            $brlf_brnd_logo = get_field('brlf_brnd_logo');
            $set_brnd_heading = get_field('set_brnd_heading');
            $brlf_brnd_info_one = get_field('brlf_brnd_info_one');
            $brlf_brnd_info_two = get_field('brlf_brnd_info_two');
            $blb_go_to_map = get_field('blb_go_to_map');
            $set_brnd_lattitude = get_field('set_brnd_lattitude');
            $set_brnd_longitude = get_field('set_brnd_longitude');

            $city_array['zip_ln_long'][$i]['logo'] = $brlf_brnd_logo;
            $city_array['zip_ln_long'][$i]['set_brnd_heading'] = $set_brnd_heading;
            $city_array['zip_ln_long'][$i]['brlf_brnd_info_one'] = $brlf_brnd_info_one;
            $city_array['zip_ln_long'][$i]['brlf_brnd_info_two'] = $brlf_brnd_info_two;
            $city_array['zip_ln_long'][$i]['blb_go_to_map'] = $blb_go_to_map;
            $city_array['zip_ln_long'][$i]['latitude'] = $set_brnd_lattitude;
            $city_array['zip_ln_long'][$i]['longitude'] = $set_brnd_longitude;

            $i++;
        }
        wp_reset_query();
        echo json_encode($city_array);
    }
    die;
}
add_action('wp_ajax_lg_city_zip', 'lg_city_zip_data');
add_action('wp_ajax_nopriv_lg_city_zip', 'lg_city_zip_data');



function display_brand_below()
{
    $param                 = sanitize_text_field($_POST['param']);
    $selected_brnd                 = $_POST['selected_brnd'];

    if ('selected_brnd' == $param) {
        $args = array(
            'post_type' => 'brand',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $selected_brnd,
                ),
            ),
        );
        $brand_query = new WP_Query($args);
        while ($brand_query->have_posts()) {
            $brand_query->the_post();
            $set_brnd_heading = get_field('set_brnd_heading');
            $brlf_brnd_info_one = get_field('brlf_brnd_info_one');
            $brlf_brnd_info_two = get_field('brlf_brnd_info_two');
            $blb_go_to_map = get_field('blb_go_to_map');

            $post_id = get_the_ID();
            $get_terms = get_the_terms($post_id, 'brand_cat');
            $final_terms = [];
            foreach ($get_terms as $single_item) {
                if ($single_item->parent == 0) {
                    $final_terms[] = $single_item->name;
                }
            }

?>
            <div class="below_list_item_box">
                <ul class="below_list_item">
                    <li>
                        <h3> <?php echo $final_terms[0]; ?></h3>
                    </li>
                    <li>
                        <h3 class="shop_name_bold_text"><?php echo $set_brnd_heading; ?></h3>
                        <?php
                        echo $brlf_brnd_info_one;
                        ?>
                        <p> <?php
                            echo $brlf_brnd_info_two;
                            ?></p>
                        <a target="_blank" class="blb_go_to_map" href="<?php echo $blb_go_to_map; ?>">Vai alla mappa</a>
                    </li>
                </ul>
            </div>
        <?php
        }
        wp_reset_query();
    }
    die;
}
add_action('wp_ajax_display_brand_below', 'display_brand_below');
add_action('wp_ajax_nopriv_display_brand_below', 'display_brand_below');




function left_location_display_smp()
{
    $param                 = sanitize_text_field($_POST['param']);
    $set_reg                 = $_POST['set_reg'];

    if ('lmp_region' == $param) {
        $args = array(
            'post_type' => 'brand',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $set_reg,
                ),
            ),
        );
        $brand_query = new WP_Query($args);
        while ($brand_query->have_posts()) {
            $brand_query->the_post();
            $set_brnd_heading = get_field('set_brnd_heading');
            $brlf_brnd_info_one = get_field('brlf_brnd_info_one');
            $brlf_brnd_info_two = get_field('brlf_brnd_info_two');
        ?>
            <li>
                <strong><?php echo $set_brnd_heading; ?></strong>
                <?php
                echo $brlf_brnd_info_one . '<br>';
                echo $brlf_brnd_info_two;
                ?>
            </li>
        <?php
        }
        wp_reset_query();
    }
    die;
}
add_action('wp_ajax_left_location_display_smp_action', 'left_location_display_smp');
add_action('wp_ajax_nopriv_left_location_display_smp_action', 'left_location_display_smp');




function selected_city_lsmp_display()
{
    $param                 = sanitize_text_field($_POST['param']);
    $set_city                 = $_POST['set_city'];

    if ('lmp_city' == $param) {
        $args = array(
            'post_type' => 'brand',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $set_city,
                ),
            ),
        );
        $brand_query = new WP_Query($args);
        while ($brand_query->have_posts()) {
            $brand_query->the_post();
            $set_brnd_heading = get_field('set_brnd_heading');
            $brlf_brnd_info_one = get_field('brlf_brnd_info_one');
            $brlf_brnd_info_two = get_field('brlf_brnd_info_two');
        ?>
            <li>
                <strong><?php echo $set_brnd_heading; ?></strong>
                <?php
                echo $brlf_brnd_info_one . '<br>';
                echo $brlf_brnd_info_two;
                ?>
            </li>
        <?php
        }
        wp_reset_query();
    }
    die;
}
add_action('wp_ajax_selected_city_lsmp_display', 'selected_city_lsmp_display');
add_action('wp_ajax_nopriv_selected_city_lsmp_display', 'selected_city_lsmp_display');




function display_lg_below_map_reg()
{
    $param                 = sanitize_text_field($_POST['param']);
    $set_lgm_breg                 = $_POST['set_lgm_breg'];

    if ('lg_map_blw_reg' == $param) {
        $args = array(
            'post_type' => 'brand',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $set_lgm_breg,
                ),
            ),
        );
        $brand_query = new WP_Query($args);
        while ($brand_query->have_posts()) {
            $brand_query->the_post();
            $set_brnd_heading = get_field('set_brnd_heading');
            $brlf_brnd_info_one = get_field('brlf_brnd_info_one');
            $brlf_brnd_info_two = get_field('brlf_brnd_info_two');
            $blb_go_to_map = get_field('blb_go_to_map');
            $post_id = get_the_ID();
            $get_terms = get_the_terms($post_id, 'brand_cat');
            $final_terms = [];
            foreach ($get_terms as $single_item) {
                if ($single_item->parent == 0) {
                    $final_terms[] = $single_item->name;
                }
            }
        ?>
            <div class="below_list_item_box">
                <ul class="below_list_item">
                    <li>
                        <h3> <?php echo $final_terms[0]; ?></h3>
                    </li>
                    <li>
                        <h3 class="shop_name_bold_text"><?php echo $set_brnd_heading; ?></h3>
                        <?php
                        echo $brlf_brnd_info_one;
                        ?>
                        <p> <?php
                            echo $brlf_brnd_info_two;
                            ?></p>
                        <a target="_blank" class="blb_go_to_map" href="<?php echo $blb_go_to_map; ?>">Vai alla mappa</a>
                    </li>
                </ul>
            </div>
        <?php
        }
        wp_reset_query();
    }
    die;
}
add_action('wp_ajax_lg_below_map_reg', 'display_lg_below_map_reg');
add_action('wp_ajax_nopriv_lg_below_map_reg', 'display_lg_below_map_reg');




function lg_below_city_display()
{
    $param                 = sanitize_text_field($_POST['param']);
    $set_lgm_bcity                 = $_POST['set_lgm_bcity'];

    if ('lg_map_blw_city' == $param) {
        $args = array(
            'post_type' => 'brand',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'brand_cat',
                    'field'    => 'slug',
                    'terms'    => $set_lgm_bcity,
                ),
            ),
        );
        $brand_query = new WP_Query($args);
        while ($brand_query->have_posts()) {
            $brand_query->the_post();
            $set_brnd_heading = get_field('set_brnd_heading');
            $brlf_brnd_info_one = get_field('brlf_brnd_info_one');
            $brlf_brnd_info_two = get_field('brlf_brnd_info_two');
            $blb_go_to_map = get_field('blb_go_to_map');

            $post_id = get_the_ID();
            $get_terms = get_the_terms($post_id, 'brand_cat');
            $final_terms = [];
            foreach ($get_terms as $single_item) {
                if ($single_item->parent == 0) {
                    $final_terms[] = $single_item->name;
                }
            }

        ?>
            <div class="below_list_item_box">
                <ul class="below_list_item">
                    <li>
                        <h3>
                            <h3> <?php echo $final_terms[0]; ?></h3>
                        </h3>
                    </li>
                    <li>
                        <h3 class="shop_name_bold_text"><?php echo $set_brnd_heading; ?></h3>
                        <?php
                        echo $brlf_brnd_info_one;
                        ?>
                        <p> <?php
                            echo $brlf_brnd_info_two;
                            ?></p>
                        <a target="_blank" class="blb_go_to_map" href="<?php echo $blb_go_to_map; ?>">Vai alla mappa</a>
                    </li>
                </ul>
            </div>
<?php
        }
        wp_reset_query();
    }
    die;
}
add_action('wp_ajax_lg_below_city_display', 'lg_below_city_display');
add_action('wp_ajax_nopriv_lg_below_city_display', 'lg_below_city_display');
