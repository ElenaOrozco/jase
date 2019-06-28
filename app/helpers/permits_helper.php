<?php
/*

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

}*/

if ( ! function_exists('get_money'))
{
	function get_money($item)
	{
		

		return "$" .number_format($item, 2, '.', ',');
	}
}

if ( ! function_exists('mensaje_flash'))
{
	function mensaje_flash($tipo, $mensaje){
        $clase = ($tipo == 'error')? 'alert-danger': 'alert-success';
        $tipo_msj = ($tipo == 'error')? 'Error! ': 'Exito! ';
        return  '<div class="alert '.$clase.' alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>'. $tipo_msj .'</strong>'.$mensaje.'
                    </div>';
         
    }
}