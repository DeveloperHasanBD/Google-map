<?php


function lagmp_state_form_data()
{
    global $wpdb;
    $lagmp_states_table = $wpdb->prefix . 'lagmp_states';
    $param              = sanitize_text_field($_POST['param']);
    if ('state_value' == $param) {
        $state_name       = stripslashes(sanitize_text_field($_POST['state_name']));
        $state_lat       = sanitize_text_field($_POST['state_lat']);
        $state_long       = sanitize_text_field($_POST['state_long']);
        $state_lat_n_long       = $state_lat . '|' . $state_long;
        $state_result     = $wpdb->get_row("SELECT * FROM {$lagmp_states_table} WHERE state_name ='{$state_name}'");
        $is_state_name    = $state_result->state_name;

        if ($is_state_name) {
?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Oppp!</strong> already exist this name.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        } else {
            $state_name_data = [
                'state_name' => $state_name,
                'state_lat' => $state_lat,
                'state_long' => $state_long,
                'state_lat_n_long' => $state_lat_n_long,
            ];
            $wpdb->insert($lagmp_states_table, $state_name_data);
        ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Successfully!</strong> added the name
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        }
    }

    die;
}

add_action('wp_ajax_lagmp_state_form', 'lagmp_state_form_data');
add_action('wp_ajax_nopriv_lagmp_state_form', 'lagmp_state_form_data');


function lagmp_country_form_data()
{
    global $wpdb;
    $lagmp_countries_table = $wpdb->prefix . 'lagmp_countries';
    $param                 = sanitize_text_field($_POST['param']);
    if ('country_data' == $param) {
        $country_name            = stripslashes(sanitize_text_field($_POST['country_name']));
        $country_lat            = sanitize_text_field($_POST['country_lat']);
        $country_lng            = sanitize_text_field($_POST['country_lng']);
        $select_state_name       = stripslashes(sanitize_text_field($_POST['select_state_name']));
        $country_result          = $wpdb->get_row("SELECT * FROM {$lagmp_countries_table} WHERE country_name='{$country_name}'");
        $is_country_name         = $country_result->country_name;

        if ($is_country_name) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Oppp!</strong> already exist this name.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        } else {
            $country_name_data = [
                'state_name'    => $select_state_name,
                'country_name'  => $country_name,
                'country_lat'  => $country_lat,
                'country_lng'  => $country_lng,
            ];
            $wpdb->insert($lagmp_countries_table, $country_name_data);
        ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Successfully!</strong> added the data
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    <?php
        }
    }
    die;
}
add_action('wp_ajax_lagmp_country_form', 'lagmp_country_form_data');
add_action('wp_ajax_nopriv_lagmp_country_form', 'lagmp_country_form_data');

function lagmp_con_country_list()
{
    global $wpdb;
    $state            = sanitize_text_field($_POST['state']);
    $lagmp_countries_table = $wpdb->prefix . 'lagmp_countries';
    $all_countries    = $wpdb->get_results("SELECT * FROM $lagmp_countries_table WHERE state_name='{$state}'");
    ?>

    <option value="">--Seleziona il paese--</option>
    <?php
    foreach ($all_countries as $country) {
        $country_name = $country->country_name
    ?>
        <option value="<?php echo strtolower($country_name); ?>"><?php echo $country_name; ?></option>
    <?php
    }
    ?>

    </div>
    <?php

    die;
}
add_action('wp_ajax_lagmp_con_country', 'lagmp_con_country_list');
add_action('wp_ajax_nopriv_lagmp_con_country', 'lagmp_con_country_list');















function set_lat_lng_gmp_ll_country_name()
{
    global $wpdb;
    $lagmp_countries_table = $wpdb->prefix . 'lagmp_countries';
    $param              = sanitize_text_field($_POST['param']);
    if ('country_nm' == $param) {
        $get_cname            = sanitize_text_field($_POST['get_cname']);
        $state_result     = $wpdb->get_row("SELECT * FROM {$lagmp_countries_table} WHERE country_name ='{$get_cname}'");
        $country_lat = $state_result->country_lat;
        $country_lng = $state_result->country_lng;

    ?>
        <div class="form-group">
            <label for="lat_val" class="control-label">Latitude</label>
            <input type="text" value="<?php echo $country_lat; ?>" name="lat_val" id="lat_val" class="form-control">
        </div>
        <div class="form-group">
            <label for="long_val" class="control-label">Longitude</label>
            <input type="text" value="<?php echo $country_lng; ?>" name="long_val" id="long_val" class="form-control">
        </div>

        <?php
    }

    die;
}
add_action('wp_ajax_gmp_ll_country_name', 'set_lat_lng_gmp_ll_country_name');




function lagmp_shop_form_data()
{
    global $wpdb;

    $shop_dtls = $wpdb->prefix . 'lagmp_shop_details';
    $param                 = sanitize_text_field($_POST['param']);
    if ('shop_data' == $param) {
        $state_name            = stripslashes(sanitize_text_field($_POST['state_name']));
        $country               = stripslashes(sanitize_text_field($_POST['country']));
        $lat_val               = sanitize_text_field($_POST['lat_val']);
        $long_val              = sanitize_text_field($_POST['long_val']);
        $shop_ln               = stripslashes(sanitize_text_field($_POST['main_shop_location']));
        $logo_path             = sanitize_text_field($_POST['logo_path']);
        $headline              = stripslashes(sanitize_text_field($_POST['headline']));
        $adrs_line_one         = stripslashes(sanitize_text_field($_POST['adrs_line_one']));
        $adrs_line_two         = stripslashes(sanitize_text_field($_POST['adrs_line_two']));
        $tell                  = sanitize_text_field($_POST['tell']);
        $fax                   = sanitize_text_field($_POST['fax']);
        $website               = sanitize_text_field($_POST['website']);
        $email                 = sanitize_text_field($_POST['email']);
        $info                  = stripslashes(sanitize_text_field($_POST['info']));
        $info_three            = stripslashes(sanitize_text_field($_POST['info_three']));
        $get_results  = $wpdb->get_row("SELECT * FROM $shop_dtls WHERE country='{$country}' AND shop_location='{$shop_ln}'");

        $is_country_name     = $get_results->country;

        if ($is_country_name) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Oppp!</strong> already exist this data.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        } else {
            $shop_data = [
                'state_name'    => $state_name,
                'country'  => $country,
                'lat_val'  => $lat_val,
                'long_val'  => $long_val,
                'shop_location'  => $shop_ln,
                'logo_path'  => $logo_path,
                'headline'  => $headline,
                'adrs_line_one'  => $adrs_line_one,
                'adrs_line_two'  => $adrs_line_two,
                'tell'  => $tell,
                'fax'  => $fax,
                'website'  => $website,
                'email'  => $email,
                'info'  => $info,
                'info_three'  => $info_three,
            ];
            $wpdb->insert($shop_dtls, $shop_data);
        ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Successfully!</strong> added the data
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
        }
    }
    die;
}
add_action('wp_ajax_lagmp_shop_form', 'lagmp_shop_form_data');

function fd_states_n_country_data()
{
    global $wpdb;
    $updt_shop_dtls = $wpdb->prefix . 'lagmp_shop_details';
    $lagmp_countries = $wpdb->prefix . 'lagmp_countries';
    $lagmp_states = $wpdb->prefix . 'lagmp_states';
    $fd_param                 = sanitize_text_field($_POST['param']);
    $fd_state                 = sanitize_text_field($_POST['fd_state']);

    if ('get_fd_country' == $fd_param) {

        $get_st_results  = $wpdb->get_row("SELECT * FROM $lagmp_states WHERE state_lat_n_long='{$fd_state}'");
        $get_st_name = $get_st_results->state_name;

        $fd_get_results  = $wpdb->get_results("SELECT * FROM $lagmp_countries WHERE state_name='{$get_st_name}' AND country_lat !='' AND country_lng !=''");

        ?>
        <option value="34.0479|100.6197">Seleziona Città <i class="fas fa-chevron-down"></i></option>
        <?php
        foreach ($fd_get_results as $fds_country) {
            $lat_val = $fds_country->country_lat;
            $long_val = $fds_country->country_lng;
            $fds_country_name = strtolower($fds_country->country_name);
        ?>
            <option value="<?php echo $lat_val . '|' . $long_val; ?>"><?php echo ucwords($fds_country_name); ?></option>
        <?php
        }
        ?>

    <?php
    }
    die;
}
add_action('wp_ajax_fd_states_n_country', 'fd_states_n_country_data');
add_action('wp_ajax_nopriv_fd_states_n_country', 'fd_states_n_country_data');




function gmp_shop_from_inner_country()
{
    global $wpdb;
    $lagmp_countries = $wpdb->prefix . 'lagmp_countries';
    $updt_shop_dtls = $wpdb->prefix . 'lagmp_shop_details';
    $param                 = sanitize_text_field($_POST['param']);
    $inner_lat                 = sanitize_text_field($_POST['inner_lat']);
    $inner_lng                 = sanitize_text_field($_POST['inner_lng']);

    if ('shop_ictry' == $param) {
        $get_cntry_result  = $wpdb->get_row("SELECT * FROM $lagmp_countries WHERE country_lat='{$inner_lat}' AND country_lng='{$inner_lng}'");
        $country_name = $get_cntry_result->country_name;
        $get_inner_results  = $wpdb->get_results("SELECT * FROM $updt_shop_dtls WHERE country='{$country_name}'");
        $get_inner_shops = [];


        foreach ($get_inner_results as $inner_item) {
            $get_inner_shops[] .= $inner_item->country;
        }
        $is_inner_shop = count($get_inner_shops);
    ?>

        <option value="34.0479|100.6197">Seleziona CAP <i class="fas fa-chevron-down"></i></option>
        <?php
        if ($is_inner_shop > 0) {
        ?>
            <script>
                jQuery(".pointed_shop_inner_country").addClass("different_shop_display_country");
            </script>
            <?php
            foreach ($get_inner_results as $location) {
                $lat_val = $location->lat_val;
                $long_val = $location->long_val;
                $location = strtolower($location->shop_location);
                if ($location) {
            ?>
                    <option value="<?php echo $lat_val . '|' . $long_val; ?>"><?php echo ucwords($location); ?></option>
            <?php
                }
            }
        }

        if (($is_inner_shop == 1) || ($is_inner_shop == 0)) {
            ?>
            <style>
                .pointed_shop_inner_country {
                    /*display: none;*/
                }
            </style>
        <?php
        }
        ?>

<?php
    }
    die;
}
add_action('wp_ajax_gmp_shop_inner_country', 'gmp_shop_from_inner_country');
add_action('wp_ajax_nopriv_gmp_shop_inner_country', 'gmp_shop_from_inner_country');






// function lagmp_countries_data()
// {
    // global $wpdb;
    // $updt_shop_dtls = $wpdb->prefix . 'lagmp_shop_details';
    // $updt_param                 = sanitize_text_field($_POST['get_country_name']);
    // echo "<pre>";
    // print_r($_POST);

    // $wpdb->update( 
    //     $updt_shop_dtls, 
    //     array( 
    //         'lat_val' => 'value1',   // string
    //         'long_val' => 'value2'    // integer (number) 
    //     ), 
    //     array( 'ID' => 1 ),
    // );
    // $asdasd = $_POST;
    // $dcode = json_decode($asdasd);
    // print_r($asdasd);

    // die;
// }
// add_action('wp_ajax_lagmp_countries', 'lagmp_countries_data');
// add_action('wp_ajax_nopriv_lagmp_countries', 'lagmp_countries_data');