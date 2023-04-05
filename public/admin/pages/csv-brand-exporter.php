<?php

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=shop.csv');
global $wpdb;
$shop_details_table   = $wpdb->prefix . 'lagmp_shop_details';

$user_id                = '';
if (is_user_logged_in()) {
    $user_id = get_current_user_id();
}

$db_name    = $wpdb->dbname;
$servername = "localhost";
$username   = "root";
$password   = "";
$db         = $db_name;


// $servername = "localhost";
// $username   = "pintexre_PntxNew";
// $password   = "PntxNew12!@:";
// $db         = "pintexre_pintex_new";


$shops_query     = "SELECT * from {$shop_details_table}";
$con                = mysqli_connect($servername, $username, $password, $db);
$shops_result    = mysqli_query($con, $shops_query);


$output = fopen("php://output", "w");

fputcsv($output, array('ID', 'State'));


while ($row = mysqli_fetch_assoc($shops_result)) {

    $data                   =  [];
    
    $data['id']             = $row['id'];
    $data['state_name']     = $row['state_name'];

    // $data['id']             = $row['id'];
    // $data['state_name']     = $row['state_name'];

    fputcsv($output, $data);
    // echo "<pre>";
    // print_r($data);
}
   
fclose($output);
exit();
