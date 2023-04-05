(function ($) {
    $(document).ready(function () {

        $('#state_list_table').DataTable();
        $('#country_list_table').DataTable();
        $('#shop_list_table').DataTable();

        $("#upload_logo").on("click", function () {
            var upload_logo = wp.media({
                title: "Upload logo",
                multiple: false,
            }).open().on("select", function () {
                var uploaded_logo_image = upload_logo.state().get("selection").first();
                var get_logo_url = uploaded_logo_image.toJSON().url;
                $("#show_logo_image").html("<img src='" + get_logo_url + "' style='height: 130px; width: 150px; border-radius: 10px;'>");
                $("#logo_url").val(get_logo_url);
            });
        });


        // fund state form valiodation 

        $("#state_form").validate({
            rules: {
                state_name: {
                    required: true
                },
                state_lat: {
                    required: true
                },
                state_long: {
                    required: true
                },
            },
            submitHandler: function () {
                var url = action_url_ajax.ajax_url;
                var form = $("#state_form");
                $.ajax({
                    url: url,
                    data: form.serialize() + '&action=' + 'lagmp_state_form' + '&param=' + 'state_value',
                    type: 'post',
                    success: function (data) {
                        $("#state_messege").html(data);
                    }
                });
                document.getElementById('state_form').reset();
                // $("#state_form input[type='submit']").attr('disabled', 'disabled');
            }
        });


        // fund state form valiodation 

        $("#country_form").validate({
            rules: {
                country_name: {
                    required: true
                },
                country_lat: {
                    required: true
                },
                country_lng: {
                    required: true
                },
                select_state_name: {
                    required: true
                },
            },
            submitHandler: function () {
                var url = action_url_ajax.ajax_url;
                var form = $("#country_form");
                $.ajax({
                    url: url,
                    data: form.serialize() + '&action=' + 'lagmp_country_form' + '&param=' + 'country_data',
                    type: 'post',
                    success: function (data) {
                        $("#country_messege").html(data);
                    }
                });
                document.getElementById('country_form').reset();
                // $("#user_fund_transfer_form .submit_btn_hide").attr('disabled', 'disabled');

            }
        });


        // fund state form valiodation 

        $("#shop_form").validate({
            rules: {
                state_name: {
                    required: true
                },
                country: {
                    required: true
                },
                lat_val: {
                    required: true
                },
                long_val: {
                    required: true
                },
            },
            submitHandler: function () {
                var url = action_url_ajax.ajax_url;
                var form = $("#shop_form");
                $.ajax({
                    url: url,
                    data: form.serialize() + '&action=' + 'lagmp_shop_form' + '&param=' + 'shop_data',
                    type: 'post',
                    success: function (data) {
                        $("#shop_data_messege").html(data);
                    }
                });
                document.getElementById('shop_form').reset();
                // $("#user_fund_transfer_form .submit_btn_hide").attr('disabled', 'disabled');

            }
        });


        $("#select_state_name").on('change', function () {
            $(".display_cntry_list").addClass('visible_cntry_list');

        });




        $(".get_country_as_lat_lng").on('change', function () {
            var get_country_nm = $(this).val();
            // alert(fd_states);
            var url = action_url_ajax.ajax_url;
            $.ajax({
                url: url,
                data: '&action=' + 'gmp_ll_country_name' + '&param=' + 'country_nm' + '&get_cname=' + get_country_nm,
                type: 'post',
                success: function (data) {
                    $(".set_lt_long_value").html(data);
                }
            });
        });

        


        // conditional country display 
        $("#select_state_name").on('change', function () {
            var selected_state_name = $(this).val();

            var url = action_url_ajax.ajax_url;
            $.ajax({
                url: url,
                data: '&action=' + 'lagmp_con_country' + '&param=' + 'get_country' + '&state=' + selected_state_name,
                type: 'post',
                success: function (data) {
                    $(".get_country_as_lat_lng").html(data);
                }
            });
        });








    });
})(jQuery)