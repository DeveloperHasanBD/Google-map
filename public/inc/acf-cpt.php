<?php
function cptui_register_my_cpts_brand()
{



    /**
     * Post Type: Luce.
     */

    $labels = [
        "name" => __("Luce", "miloox"),
        "singular_name" => __("Luce", "miloox"),
        "menu_name" => __("My Products", "miloox"),
        "all_items" => __("All Products", "miloox"),
        "add_new" => __("Add New", "miloox"),
        "add_new_item" => __("Add New Product", "miloox"),
        "edit_item" => __("Edit Product", "miloox"),
        "new_item" => __("New Product", "miloox"),
        "view_item" => __("View Product", "miloox"),
        "view_items" => __("View Products", "miloox"),
        "search_items" => __("Search Products", "miloox"),
        "not_found" => __("No Products found", "miloox"),
        "not_found_in_trash" => __("No Products found in Trash", "miloox"),
        "parent" => __("Parent Product:", "miloox"),
        "featured_image" => __("Featured Image", "miloox"),
        "set_featured_image" => __("Set Featured Image", "miloox"),
        "remove_featured_image" => __("Remove Featured Image", "miloox"),
        "use_featured_image" => __("Use Featured Image", "miloox"),
        "archives" => __("Product archives", "miloox"),
        "insert_into_item" => __("Insert into product", "miloox"),
        "uploaded_to_this_item" => __("Uploaded to this product", "miloox"),
        "filter_items_list" => __("Filter Product List", "miloox"),
        "items_list_navigation" => __("Products List Navigation", "miloox"),
        "items_list" => __("Products List", "miloox"),
        "attributes" => __("Products Attributes", "miloox"),
        "name_admin_bar" => __("Product", "miloox"),
        "item_published" => __("Product Published", "miloox"),
        "item_published_privately" => __("Product published privately.", "miloox"),
        "item_reverted_to_draft" => __("Product reverted to draft.", "miloox"),
        "item_scheduled" => __("Product scheduled", "miloox"),
        "item_updated" => __("Product Updated", "miloox"),
        "parent_item_colon" => __("Parent Product:", "miloox"),
    ];

    $args = [
        "label" => __("Luce", "miloox"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "rest_namespace" => "wp/v2",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "can_export" => false,
        "rewrite" => ["slug" => "luce", "with_front" => true],
        "query_var" => true,
        "menu_position" => 8,
        "menu_icon" => "dashicons-products",
        "supports" => ["title", "editor", "thumbnail", "excerpt", "custom-fields", "revisions", "author"],
        "show_in_graphql" => false,
    ];

    register_post_type("product", $args);


    /**
     * Post Type: Brands.
     */

    $labels = [
        "name" => __("Brands", "labor"),
        "singular_name" => __("brand", "labor"),
    ];

    $args = [
        "label" => __("Brands", "labor"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "can_export" => false,
        "rewrite" => ["slug" => "brand", "with_front" => true],
        "query_var" => true,
        "supports" => ["title", "editor"],
        "show_in_graphql" => false,
    ];

    register_post_type("brand", $args);



    /**
     * Taxonomy: Categories.
     */

    $labels = [
        "name" => __("Categories", "labor"),
        "singular_name" => __("Category", "labor"),
    ];


    $args = [
        "label" => __("Categories", "labor"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'brand_cat', 'with_front' => true,],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "show_tagcloud" => false,
        "rest_base" => "brand_cat",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
        "sort" => false,
        "show_in_graphql" => false,
    ];
    register_taxonomy("brand_cat", ["brand"], $args);



    /**
     * Taxonomy: Categories.
     */

    $labels = [
        "name" => __("Categories", "miloox"),
        "singular_name" => __("Category", "miloox"),
        "menu_name" => __("Category", "miloox"),
        "all_items" => __("All Categories", "miloox"),
        "edit_item" => __("Edit Category", "miloox"),
        "view_item" => __("View Category", "miloox"),
        "update_item" => __("Update Category Name", "miloox"),
        "add_new_item" => __("Add New Category", "miloox"),
        "new_item_name" => __("New Category Name", "miloox"),
        "parent_item" => __("Parent Category", "miloox"),
        "parent_item_colon" => __("Parent Category:", "miloox"),
        "search_items" => __("Search Category", "miloox"),
        "popular_items" => __("Popular Category:", "miloox"),
        "separate_items_with_commas" => __("Add Categories with comas", "miloox"),
        "add_or_remove_items" => __("Add or Remove Category", "miloox"),
        "choose_from_most_used" => __("Choose from the most used Category", "miloox"),
        "not_found" => __("No Categories found", "miloox"),
        "no_terms" => __("No Category", "miloox"),
        "items_list_navigation" => __("Category list navigation", "miloox"),
        "items_list" => __("Category list", "miloox"),
        "back_to_items" => __("Back to Category", "miloox"),
    ];


    $args = [
        "label" => __("Categories", "miloox"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'product_category', 'with_front' => true,],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "show_tagcloud" => false,
        "rest_base" => "product_category",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "rest_namespace" => "wp/v2",
        "show_in_quick_edit" => false,
        "sort" => false,
        "show_in_graphql" => false,
    ];
    register_taxonomy("product_category", ["product"], $args);
}

add_action('init', 'cptui_register_my_cpts_brand');


function lmp_acf_code()
{
    if (function_exists('acf_add_local_field_group')) :

        acf_add_local_field_group(array(
            'key' => 'group_625ce18af35d8',
            'title' => 'Brand location display under map',
            'fields' => array(
                array(
                    'key' => 'field_625ce1accbdc1',
                    'label' => 'Brand location display under map',
                    'name' => 'brlf_brand_locations',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => '',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_625ce1d2cbdc2',
                            'label' => 'Location',
                            'name' => 'blf_sng_location',
                            'type' => 'wysiwyg',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'tabs' => 'all',
                            'toolbar' => 'full',
                            'media_upload' => 0,
                            'delay' => 0,
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'brand',
                    ),
                ),
            ),
            'menu_order' => 2,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'left',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
                1 => 'excerpt',
                2 => 'discussion',
                3 => 'comments',
                4 => 'revisions',
            ),
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));

    endif;

    if (function_exists('acf_add_local_field_group')) :

        acf_add_local_field_group(array(
            'key' => 'group_6260eb936dc83',
            'title' => 'Set brand location',
            'fields' => array(
                array(
                    'key' => 'field_62611b3a5da19',
                    'label' => 'Logo',
                    'name' => 'brlf_brnd_logo',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'url',
                    'preview_size' => 'medium',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
                array(
                    'key' => 'field_6260ebbe25818',
                    'label' => 'Heading',
                    'name' => 'set_brnd_heading',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_62611b515da1a',
                    'label' => 'Info one',
                    'name' => 'brlf_brnd_info_one',
                    'type' => 'wysiwyg',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_62611b6c5da1b',
                    'label' => 'Info two',
                    'name' => 'brlf_brnd_info_two',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_62611b9efec42',
                    'label' => 'Go to map',
                    'name' => 'blb_go_to_map',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_6260ebd825819',
                    'label' => 'Lattitude',
                    'name' => 'set_brnd_lattitude',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_6260ebe42581a',
                    'label' => 'Longitude',
                    'name' => 'set_brnd_longitude',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'brand',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'left',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
                1 => 'excerpt',
                2 => 'discussion',
                3 => 'comments',
            ),
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));

    endif;
    if (function_exists('acf_add_local_field_group')) :

        acf_add_local_field_group(array(
            'key' => 'group_6279129e46777',
            'title' => 'Blog slider',
            'fields' => array(
                array(
                    'key' => 'field_627912c0fcd31',
                    'label' => 'Slider images',
                    'name' => 'hmlx_slider_images',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => '',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_627912d8fcd32',
                            'label' => 'Slider single item',
                            'name' => 'hb_mlx_slider_single_item',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'url',
                            'preview_size' => 'medium',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'post',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'left',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'excerpt',
                1 => 'discussion',
                2 => 'comments',
                3 => 'revisions',
            ),
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));

    endif;
}
add_action('init', 'lmp_acf_code');
