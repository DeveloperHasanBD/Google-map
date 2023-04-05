<!DOCTYPE html>
<html>

<head>
    <style>
        .container-fluid.gmp_top_menu {
            width: 89%;
            margin: auto;
            padding-top: 70px;
        }

        .lagmp_menu svg {
            position: absolute;
            top: 15px;
            right: 20px;
        }


        .lagmp_menu.lm_menu select {
            text-transform: uppercase;
            font-family: 'Montserrat-Light';
        }


        .lagmp_menu {
            position: relative;
        }


        .pointed_country_fd.display_country {
            position: relative;
        }

        div#different_location_sp {
            position: relative;
        }

        .lagmp_menu.lm_menu {
            display: flex;
            align-items: center;
            justify-content: start;
            margin-bottom: 30px;
        }

        .lagmp_area {
            padding: 0;
        }

        .lagmp_menu.lm_menu div {
            width: 33.33%;
        }

        .lagmp_menu.lm_menu div:nth-child(2) {
            margin: 0px 10px;
        }

        .hide_marker {
            display: none;
        }

        select.lg_select_region,
        .lg_zip {
            display: none;
        }

        .gm-style-iw-d a {
            text-decoration: underline;
            color: #000;
            font-family: 'Montserrat-Light';
            margin-top: 10px;
        }

        .lg_zip {
            margin-left: 10px;
        }

        .gm-style-iw-d p {
            margin: 0;
            line-height: 18px;
        }

        .gm-style-iw-d h3 {
            margin: 0px;
            color: #000;
            font-family: 'Montserrat-Light';
            margin-bottom: 12px;
            margin-top: 5px;
            font-size: 18px;
        }

        .left_info_select_region.lg_select_region {
            display: block;
        }

        ul.below_list_item {
            display: flex;
            padding: 80px 0px 40px;
            border-bottom: 1px solid #ddd;
        }

        ul.below_list_item li:first-child {
            width: 20%;
        }

        ul.below_list_item li:last-child {
            width: 80%;
        }

        ul.below_list_item h3 {
            font-family: 'Montserrat-ExtraLight';
            font-size: 32px;
        }

        ul.below_list_item p {
            font-family: 'Montserrat-ExtraLight';
            font-size: 22px;
        }

        .below_list_item_box:hover {
            background: #f4f4f4;
        }

        .container-fluid.below_shop_list_width {
            width: 100%;
        }

        ul.below_list_item {
            width: 90%;
            margin: auto;
        }

        .map_top_title h2 {
            font-family: 'Montserrat-ExtraLight';
            font-size: 28px;
            margin-bottom: 10px;
        }

        ul.below_list_item p b {
            font-family: 'Montserrat-SemiBold';
            font-size: 25px;
        }

        .form-select:focus {
            box-shadow: none;
        }

        select {
            border-radius: 0px !important;
        }

        @media all and (max-width: 800px) {
            .map_top_title h2 {
                font-size: 30px;
            }

            .lagmp_menu.lm_menu {
                display: inherit;
            }

            select#lg_brand_locations {
                max-width: 100% !important;
            }

            .lagmp_menu.lm_menu div {
                width: 100%;
            }

            .lagmp_menu.lm_menu div:nth-child(2) {
                margin: 10px 0px;
            }

            ul.below_list_item li:first-child {
                width: 45%;
            }

            ul.below_list_item li:last-child {
                width: 55%;
                padding-left: 20px;
            }

            ul.below_list_item p {
                font-size: 18px;
            }

            ul.below_list_item h3 {
                font-size: 25px;
            }


        }
    </style>


</head>

<body>

    <?php

    function get_region_as_brand()
    {
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $terms_table = $table_prefix . 'terms';
        $term_taxonomy_table = $table_prefix . 'term_taxonomy';

        $as_brnd_get_slug = $_SERVER['REQUEST_URI'];
        $as_brnd_array_slug = explode("/", $as_brnd_get_slug);
        $as_brnd_final_array = [];
        foreach ($as_brnd_array_slug as $key => $item) {
            if ($as_brnd_array_slug[$key] !== '') {
                $as_brnd_final_array[] = $item;
            }
        }

        $as_brnd_last_slug = end($as_brnd_final_array);
        $get_term_id = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE slug= '{$as_brnd_last_slug}'");
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
        $count_regions = count($get_term_names);

    ?>
        <option value="">Seleziona Regione</option>
        <?php
        for ($i = 0; $i < $count_regions; $i++) {
        ?>
            <option value="<?php echo $get_term_slugs[$i]; ?>"><?php echo ucwords($get_term_names[$i]); ?></option>
    <?php
        }
    }


    $get_slug = $_SERVER['REQUEST_URI'];
    $array_slug = explode("/", $get_slug);
    $final_array = [];
    foreach ($array_slug as $key => $item) {
        if ($array_slug[$key] !== '') {
            $final_array[] = $item;
        }
    }

    $get_last_slug = end($final_array);

    global $wpdb;
    $table_prefix = $wpdb->prefix;
    $terms_table = $table_prefix . 'terms';

    $slug_result = $wpdb->get_row("SELECT * FROM {$terms_table} WHERE slug= '{$get_last_slug}'");
    $is_slug_exist = $slug_result->slug ?? '';




    if ('punti-vendita' == $get_last_slug) {
        $args = array(
            'post_type' => 'brand',
            'posts_per_page' => -1,
        );
    } else {
        if ($is_slug_exist) {
            $args = array(
                'post_type' => 'brand',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'brand_cat',
                        'field'    => 'slug',
                        'terms'    => $get_last_slug,
                    ),
                ),
            );
        } else {
            $args = array(
                'post_type' => 'brand',
                'posts_per_page' => -1,
            );
        }
    }
    $regions_query = new WP_Query($args);

    ?>
    <img id="get_marker" class="d-none hide_marker" src="<?php echo plugin_dir_url(''); ?>lagmap/public/assets/images/marker.png" alt="">

    <div class="lagmp_area">
        <div class="container-fluid gmp_top_menu ">
            <div class="row">
                <div class="col-12">
                    <div class="map_top_title">
                        <h2>Trova uno store</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">

                    <div class="lagmp_menu lm_menu">
                        <div class="brand_locations">
                            <select id="lg_brand_locations" class="form-select form-control display_brand_below">
                                <?php get_bricolife_brand_locations(); ?>
                            </select>
                        </div>
                        <div class="regione_mitem">
                            <select name="select_state" id="lg_select_region" class="lg_below_map_reg form-select lg_select_region lg_select_region form-control">
                            </select>
                        </div>

                        <div class="pointed_country_fd">
                            <select name="select_country" id="lg_country_city" class="lg_below_city_display selected_city_lsmp_display form-select form-control">
                            </select>
                        </div>


                        <!--<div id="" class="lg_zip">-->
                        <!--    <select name="shop_inner_country" id="lg_city_zip" class="form-select form-control">-->
                        <!--    </select>-->
                        <!--</div>-->


                    </div>
                </div>
            </div>
        </div>
        <div id="map-canvas" class="mlx_google_map" style="width: 100%; height: 650px;"> </div>
        <div class="container-fluid below_shop_list_width">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="h_lsinfo_locaiton_list display_brand_location">
                        <?php
                        // echo "<pre>";
                        // print_r($regions_query);
                        while ($regions_query->have_posts()) {
                            $regions_query->the_post();
                            $set_brnd_heading = get_field('set_brnd_heading');
                            $brlf_brnd_info_one = get_field('brlf_brnd_info_one');
                            $brlf_brnd_info_two = get_field('brlf_brnd_info_two');


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
                                    </li>
                                </ul>
                            </div>

                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row" style="display: none;">
                <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                    <div id="pointed_countries"></div>
                    <?php


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

                        $all_brands[$i]['logo'] = $brlf_brnd_logo;
                        $all_brands[$i]['set_brnd_heading'] = $set_brnd_heading;
                        $all_brands[$i]['brlf_brnd_info_one'] = $brlf_brnd_info_one;
                        $all_brands[$i]['brlf_brnd_info_two'] = $brlf_brnd_info_two;
                        $all_brands[$i]['blb_go_to_map'] = $blb_go_to_map;
                        $all_brands[$i]['latitude'] = $set_brnd_lattitude;
                        $all_brands[$i]['longitude'] = $set_brnd_longitude;

                        $i++;
                    }
                    $get_cou_results = json_encode($all_brands, true);
                    ?>

                    <div style="height: 0; visivility: hidden; opacity: 0" id="get_default_countries"><?php echo $get_cou_results; ?></div>

                    <div id="get_all_shops"><?php //echo $get_shops_results; 
                                            ?></div>

                    <div class="map_box" style="display: none;">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>


    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAA9QJbq6AiXPuftMWPIIgN53HAdbF50tI"></script>

</body>

</html>