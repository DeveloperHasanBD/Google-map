<?php
function brand_csv_import_processing()
{

    global $wpdb;
   

    $brand_csv_submit_btn = $_POST['brand_csv_submit_btn'] ?? '';
    if ('Upload Brand CSV' == $brand_csv_submit_btn) {

        $allowed_file_type = array('csv');
        $filename = $_FILES['brand_csv_file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array($ext, $allowed_file_type)) {
            $handle = fopen($_FILES['brand_csv_file']['tmp_name'], "r");

            $all_brands = [];
            while (($data = fgetcsv($handle)) !== FALSE) {

                $all_brands[] = $data;
            }

            unset($all_brands[0]);

            foreach ($all_brands as $single_brand) {

                $first = $wpdb->get_row("SELECT * FROM `" . $wpdb->prefix . "terms` WHERE `name` = '" . $single_brand[1] . "'");
                $second = $wpdb->get_row("SELECT * FROM `" . $wpdb->prefix . "terms` WHERE `name` = '" . $single_brand[2] . "'");
                $third = $wpdb->get_row("SELECT * FROM `" . $wpdb->prefix . "terms` WHERE `name` = '" . $single_brand[3] . "'");

                $post_result = $wpdb->get_row("SELECT * FROM `" . $wpdb->prefix . "posts` WHERE `post_title` = '" . $single_brand[0] . "' AND post_status ='publish'");

                if (isset($post_result->post_title)) {
                } else {

                    $first = $wpdb->get_row("SELECT * FROM `" . $wpdb->prefix . "terms` WHERE `name` = '" . $single_brand[1] . "'");
                    $second = $wpdb->get_row("SELECT * FROM `" . $wpdb->prefix . "terms` WHERE `name` = '" . $single_brand[2] . "'");
                    $third = $wpdb->get_row("SELECT * FROM `" . $wpdb->prefix . "terms` WHERE `name` = '" . $single_brand[3] . "'");
                   

                    $cat_id = 0;
                    if (isset($first->term_id)) {
                        $cat_id = $first->term_id;
                    } else {
                        $cat_defaults = array(
                            'taxonomy'             => 'brand_cat',
                            'cat_name'             => $single_brand[1],
                            'category_description' => '',
                            'category_nicename'    => '',
                            'category_parent'      => '',
                        );
                        $cat_id =   wp_insert_category($cat_defaults);
                    }

                    $reg_id = 0;
                    if (isset($second->term_id)) {
                        $reg_id = $second->term_id;
                    } else {
                        $reg_defaults = array(
                            'taxonomy'             => 'brand_cat',
                            'cat_name'             => $single_brand[2],
                            'category_description' => '',
                            'category_nicename'    => '',
                            'category_parent'      => $cat_id,
                        );
                        $reg_id =   wp_insert_category($reg_defaults);
                    }
                    $city_id = 0;

                    if (isset($third->term_id)) {
                        $city_id = $third->term_id;
                    } else {
                        $city_defaults = array(
                            'taxonomy'             => 'brand_cat',
                            'cat_name'             => $single_brand[3],
                            'category_description' => '',
                            'category_nicename'    => '',
                            'category_parent'      => $reg_id,
                        );
                        $city_id =   wp_insert_category($city_defaults);
                    }

                    $my_post = array(
                        'post_title'    => $single_brand[0],
                        'post_status'   => 'publish',
                        'post_type'   => 'brand',
                    );


                    $brand_cat = array();

                    if ($cat_id > 0) {
                        $brand_cat[0] = $cat_id;
                    }

                    if ($reg_id > 0) {
                        $brand_cat[1] = $reg_id;
                    }

                    if ($city_id > 0) {
                        $brand_cat[2] = $city_id;
                    }

                    $post_ID = wp_insert_post($my_post);

                    wp_set_post_terms($post_ID, $brand_cat, 'brand_cat');

                    add_post_meta($post_ID, 'set_brnd_heading', $single_brand[5]);
                    add_post_meta($post_ID, 'set_brnd_lattitude', $single_brand[9]);
                    add_post_meta($post_ID, 'set_brnd_longitude', $single_brand[10]);

                    $image = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $single_brand[4]));


                    if (isset($image[0])) {
                        add_post_meta($post_ID, 'brlf_brnd_logo', $image[0]);
                    } else {
                        // add_post_meta($post_ID, 'brlf_brnd_logo', 'undefined');
                    }

                    add_post_meta($post_ID, 'brlf_brnd_info_one', $single_brand[6]);
                    add_post_meta($post_ID, 'brlf_brnd_info_two', $single_brand[7]);
                    add_post_meta($post_ID, 'blb_go_to_map', $single_brand[8]);
                }
            }


?>
            <div class="alert alert-success">
                <strong>Successfully!</strong> Imported CSV file
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-danger">
                <strong>Please</strong> Upload only CSV file
            </div>
<?php
        }
    }
}
?>