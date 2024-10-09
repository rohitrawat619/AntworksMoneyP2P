<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function getSeprateValues($input){
    $input = base64_decode($input);
    $values = explode('||', $input);
	
	if(count($values) < 2){
		return null;
	}
    list($value1, $value2) = $values;
    $arr = array(
        'theme_id' => $value1,
        'partner_id' => $value2
    );
    return $arr;

}

?>