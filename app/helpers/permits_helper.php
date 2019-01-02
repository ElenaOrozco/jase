<?php

function is_contractor() {
    // Get current CodeIgniter instance
    $CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    $perfil = $CI->session->userdata('perfil');
    return  ($perfil != 3)?false :true; 
}


function is_supervisor(){

}


function is_admin(){
	$CI =& get_instance();
	return  ($CI->session->userdata('admin'))?true :false; 
}


function getBaseUrl(){
	if(is_contractor()){
		return base_url("contratista");
	}else{
		return base_url();
	}

}

if ( ! function_exists('get_money'))
{
	function get_money($item)
	{
		

		return "$" .number_format($item, 2, '.', ',');
	}
}