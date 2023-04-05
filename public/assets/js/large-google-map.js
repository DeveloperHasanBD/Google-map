
jQuery(document).ready(function () {
 
  var data = JSON.parse(document.getElementById('get_default_countries').innerHTML);
  ViewCustInGoogleMap(data);
    
});


    
var mlocation_lat = 46.0379;
var mlocation_long = 11.1074;


// var mlocation_lat = 23.8103;
// var mlocation_long = 90.4125;


var map;
var latlng;
var infowindow;


// large map js 




jQuery("select#lg_country_city").on('change', function () {
    $(".lg_zip").css({ 'display': 'block' });
});

jQuery("select#lg_brand_locations").on('change', function () {
    $("select#lg_select_region").css({ 'display': 'block' });
});

jQuery("#get_pointed_shop_inner_country").on('change', function () {
    $(".brand_locations").css({ 'display': 'block' });
});
jQuery("select#lg_select_region").on('change', function () {
    jQuery(".pointed_country_fd").addClass("display_country");
});

jQuery("#lg_brand_locations").on('change', function () {
    var brnd = jQuery(this).val();
    // alert(brnd);
    var url = action_url_ajax.ajax_url;
    jQuery.ajax({
        url: url,
        data: '&action=' + 'brand_locations' + '&param=' + 'location' + '&get_location=' + brnd,
        type: 'post',
        dataType: "json",
        success: function (data) {
            ViewCustInGoogleMap(data.brnd_ln_long);
            // console.log(data);
            // jQuery("#lg_country_cittbbbt").html(data);

            jQuery("#lg_select_region").html(data.regions_name);
        }
    });
});


jQuery(".display_brand_below").on('change', function () {
    var selected_brnd = jQuery(this).val();
    // alert(brnd);
    var url = action_url_ajax.ajax_url;
    jQuery.ajax({
        url: url,
        data: '&action=' + 'display_brand_below' + '&param=' + 'selected_brnd' + '&selected_brnd=' + selected_brnd,
        type: 'post',
        success: function (data) {
            jQuery(".display_brand_location").html(data);
        }
    });
});


jQuery("#lg_select_region").on('change', function () {
    var selected_region = jQuery(this).val();
    // alert(selected_region);
    var zoom_condition = 9;

    var url = action_url_ajax.ajax_url;
    jQuery.ajax({
        url: url,
        data: '&action=' + 'lg_select_region' + '&param=' + 'lg_region' + '&set_region=' + selected_region,
        type: 'post',
        dataType: "json",
        success: function (data) {
            // console.log(data);
            ViewCustInGoogleMap(data.reg_ln_long, zoom_condition);
            // jQuery("#lg_country_cittbbbt").html(data);
            jQuery("#lg_country_city").html(data.html);
        }
    });
});



jQuery("#lg_country_city").on('change', function () {
    var selected_city = jQuery(this).val();
    // alert(selected_region);
    var zoom_condition = 9;

    var url = action_url_ajax.ajax_url;
    jQuery.ajax({
        url: url,
        data: '&action=' + 'lg_country_city' + '&param=' + 'lg_city' + '&set_city=' + selected_city,
        type: 'post',
        dataType: "json",
        success: function (data) {
            // console.log(data);
            ViewCustInGoogleMap(data.city_ln_long, zoom_condition);
            // jQuery("#lg_country_cittbbbt").html(data);
            jQuery("#lg_city_zip").html(data.html);
        }
    });
});



jQuery("#lg_city_zip").on('change', function () {
    var selected_zip = jQuery(this).val();
    // alert(selected_zip);
    var zoom_condition = 11;

    var url = action_url_ajax.ajax_url;
    jQuery.ajax({
        url: url,
        data: '&action=' + 'lg_city_zip' + '&param=' + 'lg_zip' + '&set_zip=' + selected_zip,
        type: 'post',
        dataType: "json",
        success: function (data) {
            // console.log(data);
            ViewCustInGoogleMap(data.zip_ln_long, zoom_condition);
            jQuery("#lg_country_cittbbbt").html(data);
            // jQuery("#lg_city_zip").html(data.html);
        }
    });
});



jQuery(".selected_llocations_display").on('change', function () {
    var selected_reg = jQuery(this).val();
    //   alert(selected_reg);

    var url = action_url_ajax.ajax_url;
    jQuery.ajax({
        url: url,
        data: '&action=' + 'left_location_display_smp_action' + '&param=' + 'lmp_region' + '&set_reg=' + selected_reg,
        type: 'post',
        //   dataType: "json",
        success: function (data) {
            jQuery(".h_lsinfo_locaiton_list").html(data);
        }
    });
});



  jQuery(".selected_city_lsmp_display").on('change', function () {
      var selected_city = jQuery(this).val();
        // alert(selected_city);
  
      var url = action_url_ajax.ajax_url;
      jQuery.ajax({
          url: url,
          data: '&action=' + 'selected_city_lsmp_display' + '&param=' + 'lmp_city' + '&set_city=' + selected_city,
          type: 'post',
          //   dataType: "json",
          success: function (data) {
              jQuery(".h_lsinfo_locaiton_list").html(data);
          }
      });
  });
  


  jQuery(".lg_below_map_reg").on('change', function () {
      var selected_lg_reg = jQuery(this).val();
        // alert(selected_lg_reg);
  
      var url = action_url_ajax.ajax_url;
      jQuery.ajax({
          url: url,
          data: '&action=' + 'lg_below_map_reg' + '&param=' + 'lg_map_blw_reg' + '&set_lgm_breg=' + selected_lg_reg,
          type: 'post',
          //   dataType: "json",
          success: function (data) {
              jQuery(".display_brand_location").html(data);
          }
      });
  });
  
  
  
  jQuery(".lg_below_city_display").on('change', function () {
      var selected_lg_city = jQuery(this).val();
        // alert(selected_lg_reg);
  
      var url = action_url_ajax.ajax_url;
      jQuery.ajax({
          url: url,
          data: '&action=' + 'lg_below_city_display' + '&param=' + 'lg_map_blw_city' + '&set_lgm_bcity=' + selected_lg_city,
          type: 'post',
          //   dataType: "json",
          success: function (data) {
              jQuery(".display_brand_location").html(data);
          }
      });
  });
  
  
  
  
function ViewCustInGoogleMap(data, zoom_condition) {


let mid_point = Math.ceil(data.length / 2);
if(mid_point <= 1)
{
    mid_point = 0;
}
if (data[mid_point] !== undefined) {
  let point_of_entity = data[mid_point];
  let latitude  = point_of_entity.latitude;
  let longitude = point_of_entity.longitude;
  mlocation_lat = latitude;
  mlocation_long = longitude;
}

    var gm = google.maps; //create instance of google map
    //add initial map option

    var zoom_change = 6;
    if (zoom_condition) {
        zoom_change = zoom_condition;
    } else {
        zoom_change = 6;
    }
    var mapOptions = {
        center: new google.maps.LatLng(mlocation_lat, mlocation_long), // Coimbatore = (11.0168445, 76.9558321)
        zoom: zoom_change,
        //mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    //bine html tag to show the google map and bind mapoptions
    mapcanvas = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
    //create instance of google information windown
    infowindow = new google.maps.InfoWindow();
    var marker, i;

    var get_marker = jQuery("#get_marker").attr('src');
    const image = get_marker;

    //loop through all the locations and point the mark in the google map
    for (var i = 0; i < data.length; i++) {

        marker = new gm.Marker({
            position: new gm.LatLng(data[i]['latitude'], data[i]['longitude']),
            map: mapcanvas,
            icon: image
        });

        var brand_logo = '<img src=' + data[i]['logo'] + ' alt="">';
        var set_brnd_heading = ' <h3>' + data[i]['set_brnd_heading'] + '</h3>';
        var brlf_brnd_info_one = ' <p>' + data[i]['brlf_brnd_info_one'] + '</p>';
        var brlf_brnd_info_two = ' <p>' + data[i]['brlf_brnd_info_two'] + '</p>';
        var blb_go_to_map = '<a target="_blank" href=' + data[i]['blb_go_to_map'] + '>Apri su mappe</a>';

        //add info for popup tooltip
        google.maps.event.addListener(
            marker,
            'click',
            (
                function (marker, i) {
                    return function () {
                        infowindow.setContent('<img src=' + data[i]['logo'] + ' alt="">' + ' <h3>' + data[i]['set_brnd_heading'] + '</h3>' + ' <p>' + data[i]['brlf_brnd_info_one'] + '</p>' + ' <p>' + data[i]['brlf_brnd_info_two'] + '</p>' + '<a target="_blank" href=' + data[i]['blb_go_to_map'] + '>Apri su mappe</a>');
                          infowindow.open(mapcanvas, marker);
                    };
                }
            )(marker, i)

        );
    }

}