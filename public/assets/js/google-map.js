
var location_lat = 43.9424;
var location_long = 12.4578;
// loadMap();
var map;
var geocoder;





jQuery(".select_state").on('change', function () {
    var st_option_val = jQuery(this).val();
    var st_selected_val = st_option_val.split("|");
    var st_first_val = parseFloat(st_selected_val[0]);
    var st_snd_val = parseFloat(st_selected_val[1]);
    location_lat = st_first_val;
    location_long = st_snd_val;
     var zoom_condition = 8;
    loadMap(zoom_condition);
});


jQuery(".select_country").on('change', function () {
    var option_val = jQuery(this).val();
    var selected_val = option_val.split("|");
    var first_val = parseFloat(selected_val[0]);
    var snd_val = parseFloat(selected_val[1]);
    location_lat = first_val;
    location_long = snd_val;
    var zoom_condition = 9;
    loadMap(zoom_condition);
});

jQuery("#get_pointed_shop_inner_country").on('change', function () {
    var inner_shop_val = jQuery(this).val();
    var inner_selected_val = inner_shop_val.split("|");
    var inner_first_lat = parseFloat(inner_selected_val[0]);
    var inner_snd_lat = parseFloat(inner_selected_val[1]);
    location_lat = inner_first_lat;
    location_long = inner_snd_lat;
    var zoom_condition = 10;
    loadMap(zoom_condition);
});



function loadMap(zoom_condition) {
    // alert(first_val);
    if (zoom_condition) {
        var location = { lat: location_lat, lng: location_long };
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: zoom_condition,
            center: location
        });
    } else {
        var location = { lat: location_lat, lng: location_long };
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            center: location
        });
    }


    geocoder = new google.maps.Geocoder();
    var get_all_shops = JSON.parse(document.getElementById('get_all_shops').innerHTML);
    show_all_shops(get_all_shops);
}

function show_all_shops(get_all_shops) {
    var infoWindow = new google.maps.InfoWindow;
    Array.prototype.forEach.call(get_all_shops, function (data) {
        var content = document.createElement('div');
        var img = document.createElement("img");
        if (data.logo_path) {
            img.src = data.logo_path;
        }
        var heading_text = document.createElement("heading_text");
        // var shop_location = document.createElement('shop_location');
        var adrs_line_one = document.createElement('adrs_line_one');
        var adrs_line_two = document.createElement('adrs_line_two');
        var tell = document.createElement('tell');
        var fax = document.createElement('fax');
        var website = document.createElement('a');
        website.setAttribute('href', data.website);
        website.setAttribute('target', '_blank');
        var email = document.createElement('a');
        email.setAttribute('href', 'mailto:' + data.email + '', data.email);
        var info = document.createElement('info');
        var info_three = document.createElement('info_three');
        heading_text.textContent = data.headline;
        // shop_location.textContent = data.shop_location;

        const gMapReplaceAnd = heading_text.textContent;
        heading_text.textContent = gMapReplaceAnd.replace("&amp;", "&");



        adrs_line_one.textContent = data.adrs_line_one;
        adrs_line_two.textContent = data.adrs_line_two;
        tell.textContent = data.tell;
        fax.textContent = data.fax;
        website.textContent = data.website;
        website.innerHTML = "Open on Maps";
        email.textContent = data.email;
        info.textContent = data.info;
        info_three.textContent = data.info_three;

        content.appendChild(img);
        content.appendChild(heading_text);
        // content.appendChild(shop_location);
        content.appendChild(adrs_line_one);
        content.appendChild(adrs_line_two);
        content.appendChild(tell);
        content.appendChild(fax);
        content.appendChild(website);
        content.appendChild(email);
        content.appendChild(info);
        content.appendChild(info_three);

        var get_marker = jQuery("#get_marker").attr('src');
        const image = get_marker;

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(data.lat_val, data.long_val),
            map: map,
            icon: image,
        });

        marker.addListener('click', function () {
            infoWindow.setContent(content);
            infoWindow.open(map, marker);
        });
    })
}



jQuery("select#lagmp_front_end_states").on('change', function () {
    jQuery(".pointed_country_fd").addClass("display_country");
});
// jQuery(".pointed_shop_inner_country").

// document.getElementById('different_location_sp').style.display='none';


// jQuery(".get_shop_from_inner_country").on('change', function () {
//     jQuery(".pointed_shop_inner_country").addClass("display_shop_inner_country");
// });


// // conditional country display 


jQuery(".get_country_bt_state").on('change', function () {
    var fd_states = jQuery(this).val();
    // alert(fd_states);
    var url = action_url_ajax.ajax_url;
    jQuery.ajax({
        url: url,
        data: '&action=' + 'fd_states_n_country' + '&param=' + 'get_fd_country' + '&fd_state=' + fd_states,
        type: 'post',
        success: function (data) {
            jQuery("#get_pointed_countries").html(data);
        }
    });
});




jQuery(".get_shop_from_inner_country").on('change', function () {
    var get_by_inner_country = jQuery(this).val();

    var divided_lat_long = get_by_inner_country.split("|");

    var inner_lat = divided_lat_long[0];
    var inner_lng = divided_lat_long[1];

    var url = action_url_ajax.ajax_url;
    jQuery.ajax({
        url: url,
        data: '&action=' + 'gmp_shop_inner_country' + '&param=' + 'shop_ictry' + '&inner_lat=' + inner_lat + '&inner_lng=' + inner_lng,
        type: 'post',
        success: function (data) {
            jQuery("#get_pointed_shop_inner_country").html(data);
        }
    });


});






// // conditional brand location display 


jQuery("select#get_brand_locations").on('change', function () {
    $(".regione_mitem").removeClass('con_visibility');
    
    // alert("HHH");
});

jQuery("#get_brand_locations").on('change', function () {
    var brnd = jQuery(this).val();
    // alert(brnd);
    var url = action_url_ajax.ajax_url;
    jQuery.ajax({
        url: url,
        data: '&action=' + 'brand_locations' + '&param=' + 'location' + '&get_location=' + brnd,
        type: 'post',
        success: function (data) {
            jQuery(".display_brand_location").html(data);
        }
    });
});















