<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MobileController;


class LocationController extends Controller
{
   
	public function getLocation($localizacao){




		$json = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$localizacao."&key=AIzaSyA8gimLV4zVhGZgrRQUhZWWYAuWvuSTRYo");

		$json = json_decode($json, true);
		if (!$this->check_status($json))   return array();


		$MobileController = new MobileController;



		$address = array(
		    'country' => $MobileController->tratar_string($this->google_getCountry($json)),
		    'province' => $MobileController->tratar_string($this->google_getProvince($json)),
		    'city' => $MobileController->tratar_string($this->google_getCity($json)),
		    'street' => $MobileController->tratar_string($this->google_getStreet($json)),
		    'postal_code' => $MobileController->tratar_string($this->google_getPostalCode($json)),
		    'country_code' => $MobileController->tratar_string($this->google_getCountryCode($json)),
		    'formatted_address' => $MobileController->tratar_string($this->google_getAddress($json)),
		);

		return $address;
	}


	/* 
	* Check if the json data from Google Geo is valid 
	*/
	private function check_status($jsondata) {
    	if ($jsondata["status"] == "OK") return true;
	    return false;
	}


	/*
	* Given Google Geocode json, return the value in the specified element of the array
	*/

	private function google_getCountry($jsondata) {
	    return $this->Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"]);
	}
	private function google_getProvince($jsondata) {
	    return $this->Find_Long_Name_Given_Type("administrative_area_level_1", $jsondata["results"][0]["address_components"], true);
	}
	private function google_getCity($jsondata) {
		$city = $this->Find_Long_Name_Given_Type("locality", $jsondata["results"][0]["address_components"]);
	    return ($city == NULL ?
	  		$this->Find_Long_Name_Given_Type("administrative_area_level_2", $jsondata["results"][0]["address_components"]) : $city);
	}
	private function google_getStreet($jsondata) {
	    return $this->Find_Long_Name_Given_Type("street_number", $jsondata["results"][0]["address_components"]) . ' ' . $this->Find_Long_Name_Given_Type("route", $jsondata["results"][0]["address_components"]);
	}
	private function google_getPostalCode($jsondata) {
	    return $this->Find_Long_Name_Given_Type("postal_code", $jsondata["results"][0]["address_components"]);
	}
	private function google_getCountryCode($jsondata) {
	    return $this->Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"], true);
	}
	private function google_getAddress($jsondata) {
	    return $jsondata["results"][0]["formatted_address"];
	}

	/*
	* Searching in Google Geo json, return the long name given the type. 
	* (If short_name is true, return short name)
	*/

	private function Find_Long_Name_Given_Type($type, $array, $short_name = false) {
	    foreach( $array as $value) {
	        if (in_array($type, $value["types"])) {
	            if ($short_name)    
	                return $value["short_name"];
	            return $value["long_name"];
	        }
	    }
	}

}
