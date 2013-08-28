<?php
/*
Plugin Name: Geo API plugin
Plugin URI: https://github.com/boxedfish/yourls-Geo-API-plugin
Description: Geo API plugin to look up country code from a 3rdparty API if you find the local look up to be hit and miss or as in my case not working at all
Version: 1.0
Author: alexjakass
Author URI: http://boxed-rocket.com/
*/
if( !defined( 'YOURLS_ABSPATH' ) ) die();



function aa_shunt_geo_ip_to_countrycode( $location = '', $ip = '', $default = '' ) {
	if ( $ip == '' )
		$ip = yourls_get_IP();
		
	$c = curl_init();
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, "http://geoiplookup.net/geoapi.php?output=json&ipaddress=".$ip);
	curl_setopt($c,CURLOPT_TIMEOUT,2);
    $contents = curl_exec($c);
    curl_close($c);
	
	if($contents && $contents != ""){
		$location = JSON_DECODE($contents);
	}
	
	if(is_object($location) && isset($location->countryCode)) return $location->countryCode;
	return false;
}


yourls_add_filter( 'shunt_geo_ip_to_countrycode', 'aa_shunt_geo_ip_to_countrycode' );