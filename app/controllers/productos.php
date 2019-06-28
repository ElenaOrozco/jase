<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

	public function __construct() {
        
        parent::__construct();
        $this->load->model('productos_model');
        // load Pagination library
        $this->load->library('pagination');
        
    }

    public function import_productos() {
        //echo form_open_multipart('presupuesto/import_pres_db/');
        echo '
        <form action="' . site_url('productos') . '/import_productos_bd/" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <table border="0" width="100%">
            <tr><td><input type="file" name="userfile" size="20" /></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td align="center"><input type="submit" value="Subir Archivo" /></td></tr>
        </table>
        </form>';
    }
    
    public function import_productos_bd() {

        
      
        $config['upload_path'] = 'temp/';
        $config['allowed_types'] = 'xls|xlsx|XLS|XLSX';
        $config['file_name'] = md5(microtime());
        

        $this->load->library('upload', $config);
        $this->upload->initialize($config);      

        
        if (!$this->upload->do_upload()) {
            echo "Error al cargar la base de datos"; 
            exit;
        } else {
           
            
            $data = array('upload_data' => $this->upload->data());
            
            $nombre_definitivo = $data['upload_data']['full_path'];
            chmod($nombre_definitivo, 0776);

            $binario_tipo = $data['upload_data']['file_type'];
            $file_ext = $data['upload_data']['file_ext'];
            $versionExcel = "";
            $extension = "";

            if ($file_ext == ".xlsx") {
                $versionExcel = "Excel2007";
                $extension = "xlsx";
            } else if ($file_ext == ".xls") {
                $versionExcel = "Excel5";
                $extension = ".xls";
            } else {
                //die("No es excel<br>".$binario_tipo.$file_ext);
                die("No es excel<br>" . $file_ext);
            }

            $hojaactiva = 0;

            //echo $nombre_definitivo;

            $this->load->library("excel");
            $this->excel->load($nombre_definitivo, $versionExcel);
            $objWorksheet = $this->excel->setActiveSheetIndex($hojaactiva);


            //$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
            
            $highestRow = 535;
            


            $row_Inicia = 3;
            
           
            $i= 1;
            for ($row = $row_Inicia; $row <= $highestRow; ++$row) {
                // Leer siempre la columna 0
                //$guia = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
                
                        $i++;

                        $nombre = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $descripcion = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
                        
                        $idCategoria = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
                        ;


                        //Insertar Dcumento
                        $data_documento = array(
                            "nombre" => $nombre,
                            "descripcion" => $descripcion,
                            
                            'idCategoria' =>$idCategoria,
                            
                        );

                        $this->db->insert("catProductos", $data_documento);
                        $id = $this->db->insert_id();

                        echo "OK ";

            
               
            }
            
            echo $i . "inseradas";
        }
    }

    public function mensaje_flash($tipo, $mensaje){
        $clase = ($tipo == 'error')? 'alert-danger': 'alert-success';
        $tipo_msj = ($tipo == 'error')? 'Error! ': 'Exito! ';
        return  '<div class="alert '.$clase.' alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>'. $tipo_msj .'</strong>'.$mensaje.'
                    </div>';
         
    }

    public function buscar_imagen(){

        $listado = $this->productos_model->listar_productos();
        
        $path  = './uploads/'; 

        // Arreglo con todos los nombres de los archivos
        $files = array_diff(scandir($path), array('.', '..'));
var_dump($files);
echo $files[2];
        $i=2;
        foreach($listado->result() as $row){

            $code = $row->nombre;
            $file = $files[$i];

            //////foreach($files as $file){

                // Divides en dos el nombre de tu archivo utilizando el . 
                $data          = explode(".", $file);
                // Nombre del archivo
                $fileName      = $data[0];
                // Extensión del archivo 
                $fileExtension = $data[1];

                echo $code ." == ". $fileName ."<br>";

                //if($code == $fileName){
                    
                    //echo $fileName;
                    $data_producto['imagen'] = $file;
                    $this->db->where('id', $row->id);
                    $this->db->update('catProductos', $data_producto);
                    $i++;
                    if($i> 50) $i =2;
                    // Realizamos un break para que el ciclo se interrumpa
                    //break;
                //}
            //}
        }
    }

    

	
	public function index2()
	{
        $buscar = ($this->input->post('input_search'))? $this->input->post('input_search'): null;
        

        // init params
        $params = array();
        $limit_per_page = 9;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->productos_model->get_total($buscar);
 

        if ($total_records > 0) 
        {
            // get current page records
            $params["results"] = $this->productos_model->get_current_page_records($limit_per_page, $start_index, $buscar);
             

            $config['base_url'] = base_url() . 'productos/index/';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
            $this->pagination->initialize($config);
             
            // build paging links
            $params["links"] = $this->pagination->create_links();
        }
        $params['categorias'] = $this->productos_model->listar_categorias();
        
        // echo "string $buscar total $total_records <br>";
        // var_dump($params['results']->result());
        $this->load->view('productos/v_productos', $params);


		// $data['productos'] = $this->productos_model->listar_productos($idCategoria);
		// $data['categorias'] = $this->productos_model->listar_categorias();
  //       if($idCategoria)
  //           $data['categoria'] = $this->productos_model->datos_categoria($idCategoria)->row_array();
		// $this->load->view('productos/v_productos', $data);
	}


     //con esta función validamos y protegemos el buscador
    public function validar() {
        $this->form_validation->set_rules('buscando', 'buscador', 'required|min_length[2]|max_length[20]|trim|xss_clean');
        $this->form_validation->set_message('required', 'El campo no puede ir vacío!');
        $this->form_validation->set_message('min_length', 'El  campo debe tener al menos %s carácteres');
        $this->form_validation->set_message('max_length', 'El campo no puede tener más de %s carácteres');
        if ($this->form_validation->run() == TRUE) {
 
            $buscador = $this->input->post('buscando');
            $this->session->set_userdata('buscando', $buscador);
            //todo correcto y pasamos a la función index
            redirect(base_url() .'productos/', 'refresh');
        } else {
            //mostramos de nuevo el buscador con los errores
            redirect(base_url() .'productos/', 'refresh');
        }

    }

    public function ver_todos() {
        
        $buscador = "";
        $this->session->set_userdata('buscando', $buscador);
        redirect(base_url() .'productos/', 'refresh');
        

    }
 
    public function index() {
        
        
        $buscador = $this->session->userdata('buscando');
        //var_dump($buscador); exit();
        $pages = 12; //Número de registros mostrados por páginas
        $this->load->library('pagination'); //Cargamos la librería de paginación
        $config['base_url'] = base_url() . 'productos/pagina'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
        $config['total_rows'] = $this->productos_model->productos($buscador); //calcula el número de filas
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 1; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera'; //primer link
        $config['last_link'] = 'Última'; //último link
        $config['next_link'] = 'Siguiente'; //siguiente link
        $config['prev_link'] = 'Anterior'; //anterior link
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['cur_tag_open']= '&nbsp;<li class="page-item active"><a class="page-link bg-blue-primary" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        
        $this->pagination->initialize($config); //inicializamos la paginación
        //el array con los datos a paginar ya preparados
        $data["results"] = $this->productos_model->total_posts_paginados($buscador, $config['per_page'], $this->uri->segment(3));
        $data['categorias'] = $this->productos_model->listar_categorias();
        $data['buscador'] = $buscador;
        $data['total_rows'] = $this->productos_model->productos($buscador); 
        //cargamos la vista y el array data
        
        $this->load->view('productos/v_productos2', $data);
    }



    public function buscar_productos()
    {
        
        

        // init params
        $params = array();
        $limit_per_page = 9;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->productos_model->get_total($buscar);
 

        if ($total_records > 0) 
        {
            // get current page records
            $params["results"] = $this->productos_model->get_current_page_records($limit_per_page, $start_index, $buscar);
             

            $config['base_url'] = base_url() . 'productos/index/';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
            $this->pagination->initialize($config);
             
            // build paging links
            $params["links"] = $this->pagination->create_links();
        }
        $params['categorias'] = $this->productos_model->listar_categorias();
        
        echo "string $buscar total $total_records <br>";
        var_dump($params['results']->result());
        $this->load->view('productos/v_productos', $params);


        // $data['productos'] = $this->productos_model->listar_productos($idCategoria);
        // $data['categorias'] = $this->productos_model->listar_categorias();
  //       if($idCategoria)
  //           $data['categoria'] = $this->productos_model->datos_categoria($idCategoria)->row_array();
        // $this->load->view('productos/v_productos', $data);
    }

    public function datos_categoria(){
        $idCategoria =$this->input->post('idCategoria');

        echo json_encode( $this->productos_model->datos_categoria($idCategoria)->row_array() );
    }

    public function buscar(){
        $buscar = $this->input->post('input_search');
        $data['buscar'] = $buscar;
        $data['retorno'] = $this->productos_model->buscar($buscar);
        $this->load->view('productos/v_busqueda', $data);

        

    }

     public function listado_categoria2($idCategoria){
        $aCategoria = $this->productos_model->datos_categoria($idCategoria)->row_array();
        $buscador = $aCategoria['nombre'];
        $this->session->set_userdata('buscando', $buscador);
        //todo correcto y pasamos a la función index
        redirect(base_url() .'productos/', 'refresh');
    }

   

    public function listado_categoria($idCategoria){
        $pages = 12; //Número de registros mostrados por páginas
        $this->load->library('pagination'); //Cargamos la librería de paginación
        $config['base_url'] = base_url() . 'productos/listado_categoria/' .$idCategoria. '/pagina'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
        $config['total_rows'] = $this->productos_model->productos_categoria($idCategoria); //calcula el número de filas
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 3; //Número de links mostrados en la paginación
        $config['first_link'] = 'Primera'; //primer link
        $config['last_link'] = 'Última'; //último link
        $config['next_link'] = 'Siguiente'; //siguiente link
        $config['prev_link'] = 'Anterior'; //anterior link
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['cur_tag_open']= '&nbsp;<li class="page-item active"><a class="page-link bg-blue-primary" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['uri_segment'] = 5;
        $this->pagination->initialize($config); //inicializamos la paginación
        //el array con los datos a paginar ya preparados
        $data["results"] = $this->productos_model->total_posts_paginados_categoria($idCategoria, $config['per_page'], $this->uri->segment(5));
        $data['categorias'] = $this->productos_model->listar_categorias();
        $data['categoria'] = $this->productos_model->datos_categoria($idCategoria)->row_array();
        $data["links"] = $this->pagination->create_links();
        //cargamos la vista y el array data
        
        $this->load->view('productos/v_productos2', $data);
    }

    public function listado_categoria1($idCategoria)
    {
        // init params
        $params = array();
        $limit_per_page = 9;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->productos_model->get_total($idCategoria);
 
        if ($total_records > 0) 
        {
            // get current page records
            $params["results"] = $this->productos_model->get_current_page_records($limit_per_page, $start_index, $idCategoria);

             
            $config['base_url'] = base_url() . 'productos/listado_categoria/' .'/'. $idCategoria;
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
            $this->pagination->initialize($config);
             
            // build paging links
            $params["links"] = $this->pagination->create_links();
        }
        $params['categorias'] = $this->productos_model->listar_categorias();
        $params['categoria'] = $this->productos_model->datos_categoria($idCategoria)->row_array();
        
         
        $this->load->view('productos/v_productos', $params);


        // $data['productos'] = $this->productos_model->listar_productos($idCategoria);
        // $data['categorias'] = $this->productos_model->listar_categorias();
  //       if($idCategoria)
  //           $data['categoria'] = $this->productos_model->datos_categoria($idCategoria)->row_array();
        // $this->load->view('productos/v_productos', $data);
    }



    
	public function listado()
	{
		$data['productos'] = $this->productos_model->listar_productos();
		$data['categorias'] = $this->productos_model->listar_categorias();
        $data['subcategorias'] = $this->productos_model->listar_subcategorias();
		$this->load->view('admin/productos/v_productos', $data);
	}

    public function nuevo_producto(){
        $data['categorias'] = $this->productos_model->listar_categorias();
        //$data['subcategorias'] = $this->productos_model->listar_subcategorias();
        $this->load->view('admin/productos/v_nuevo_producto', $data);
    }

	public function detalle($id)
	{
        $limit = 8;
        $data['productos'] = $this->productos_model->listado_productos_slider($limit);
		$data['producto'] = $this->productos_model->datos_producto($id)->row_array();
		$this->load->view('productos/v_detalle', $data);
	}


	public function categorias()
	{
		$data['categorias'] = $this->productos_model->listar_categorias();
		$this->load->view('productos/v_categorias', $data);
	}

	public function listado_productos($idCategoria){


	}

	public function agregar_categoria(){
        //Cargar imagen
		if($_FILES['userfile']['name']){
			$this->do_upload();
			$subir['imagen'] = $_FILES['userfile']['name'];


			//echo "Cargo Archivo";
		}else{
			//echo "No cargo Archivo";
		}

        //Insertar categoria
		$subir['nombre'] = $this->input->post('nombre');
        $subir['descripcion'] = $this->input->post('descripcion');
       
        
        $result = $this->productos_model->subir_categoria($subir);  

		redirect('/productos/categorias','refresh');

	}

    public function subir_pdf(){
        
        // La configuración del Archivo 2, debe ser diferente del archivo 1
        // si configuras como el Archivo 1 no hará nada
        $config['upload_path'] = './uploads/pdf/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '21000000';
           
        $this->load->library('upload');
        // Cargamos la nueva configuración
        $this->upload->initialize($config);
        
        if (!$this->upload->do_upload('pdf')) {

            var_dump($this->upload->display_errors('', ''));
        
            return  array('error' => $this->upload->display_errors(), 'estado' =>FALSE);  
        } else{
            return TRUE;
        }

    }
    
    public function do_upload_producto() {
        $config ="";
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2000';
        $config['max_width'] = '2024';
        $config['max_height'] = '2008';
 
        $this->load->library('upload');
        // Cargamos la nueva configuración
        $this->upload->initialize($config);
        //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA UPLOAD_VIEW
        if (!$this->upload->do_upload('userfile')) {
            
             return  array('error' => $this->upload->display_errors(), 'estado' =>FALSE);  
        } else{
            return TRUE;
        }
        
    }


    //FUNCIÓN PARA CREAR LA MINIATURA A LA MEDIDA QUE LE DIGAMOS
    // function _create_thumbnail($filename){
    //     $config['image_library'] = 'gd2';
    //     //CARPETA EN LA QUE ESTÁ LA IMAGEN A REDIMENSIONAR
    //     $config['source_image'] = 'uploads/'.$filename;
    //     //$config['create_thumb'] = TRUE;
    //     $config['maintain_ratio'] = TRUE;
    //     //CARPETA EN LA QUE GUARDAMOS LA MINIATURA
    //     $config['new_image']='/uploads/categorias/';
    //     //$config['width'] = 150;
    //     $config['height'] = 150;
    //     $this->load->library('image_lib', $config); 
    //     if(!$this->image_lib->resize()){
    //         echo $this->image_lib->display_errors();
    //     }
    // }


	public function agregar_producto(){
        $subir = $this->input->post();
        $msj = "";
        // var_dump($_FILES);
        // exit();
		
        

        if(!empty($_FILES['userfile']['name'])){
            if($_FILES['userfile']['size'] > 309000){
                   
                $mensaje = $this->mensaje_flash('error', 'Tamaño de la imagen mayor a 300KB');
                $this->session->set_flashdata('correcto', $mensaje);
                $pagina_anterior=$_SERVER['HTTP_REFERER'];
                redirect($pagina_anterior,'refresh');
            }

            $_FILES['userfile']['name'] = str_replace(' ', '', $_FILES["userfile"]["name"]);
            $retorno = $this->do_upload_producto('userfile');
            
            $subir['imagen'] = $_FILES["userfile"]["name"];
            if(!$retorno) 
            $msj  .= 'Error al agregar la imagen <br>';
        }

        if( !empty($_FILES['pdf']['name']) ){
            $_FILES['pdf']['name'] = str_replace(' ', '', $_FILES["pdf"]["name"]);
            $retorno = $this->subir_pdf();
            
            $subir['pdf'] = $_FILES["pdf"]["name"];
            if(!$retorno) 
            $msj  .= 'Error al agregar el pdf <br>';
        }

        if(isset($_POST['visible']) ){
            $subir['visible'] = 0;
        } else{
            $subir['visible'] = 1;
        }
        if(isset($_POST['disponible']) ){
            $subir['disponible'] = 1;
        } else{
            $subir['disponible'] = 0;
        }
        if(isset($_POST['promocion']) ){
            $subir['promocion'] = 1;
        } else{
            $subir['promocion'] = 0;
        }

        unset($subir['userfile']);
        $result = $this->productos_model->agregar_producto($subir);  
        
        $tipo = (!$result)? 'error': 'exito';
        $msj .= (!$result)? 'Error al Agregar el Producto': ' Producto Agregado correctamente';

        $mensaje = $this->mensaje_flash($tipo, $msj);
        $this->session->set_flashdata('correcto', $mensaje);
        

		redirect('/productos/listado','refresh');

	}



	public function editar_categoria(){
        
        $msj = '';
		if($_FILES['userfile']['name']){

			$result = $this->do_upload();
            $file_info = $this->upload->data();
            $subir['imagen'] = $file_info['file_name'];
            $tipo = $result['tipo'];
            $msj  .= $result['mensaje'];
            
		}
                
		$subir['nombre'] = $this->input->post('nombre_mod');
        $subir['descripcion'] = $this->input->post('descripcion_mod');
        $result = $this->productos_model->editar_categoria($subir, $this->input->post('idCategoria_mod'));  

        $tipo = (!$result)? 'error': 'exito';
        $msj .= (!$result)? 'Error al Editar la Categoria': ' Categoria Editada correctamente';

        $mensaje = $this->mensaje_flash($tipo, $msj);
        $this->session->set_flashdata('correcto', $mensaje);
       

		redirect('/productos/categorias','refresh');

	}


    public function editar_producto($id){

        if(!$id){
            $idProducto = $this->input->post('idProducto');
            $subir = $this->input->post();
            $msj = '';
            
            if(!empty($_FILES['userfile']['name'])){
                if($_FILES['userfile']['size'] > 309000){
                   
                    $mensaje = $this->mensaje_flash('error', 'Tamaño de la imagen mayor a 300KB');
                    $this->session->set_flashdata('correcto', $mensaje);
                    $pagina_anterior=$_SERVER['HTTP_REFERER'];
                    redirect($pagina_anterior,'refresh');
                }
            
                $_FILES['userfile']['name'] = str_replace(' ', '', $_FILES["userfile"]["name"]);
                $retorno = $this->do_upload_producto('userfile');
                
                $subir['imagen'] = $_FILES["userfile"]["name"];
                if(!$retorno) 
                $msj  .= 'Error al agregar la imagen <br>';
            }

            if( !empty($_FILES['pdf']['name']) ){
                $_FILES['pdf']['name'] = str_replace(' ', '', $_FILES["pdf"]["name"]);
                $retorno = $this->subir_pdf();
                
                $subir['pdf'] = $_FILES["pdf"]["name"];
                if(!$retorno) 
                $msj  .= 'Error al agregar el pdf <br>';
            }

            
            
            if(isset($_POST['visible']) ){
                $subir['visible'] = 0;
            } else{
                $subir['visible'] = 1;
            }
            if(isset($_POST['disponible']) ){
                $subir['disponible'] = 1;
            } else{
                $subir['disponible'] = 0;
            }
            if(isset($_POST['promocion']) ){
                $subir['promocion'] = 1;
            } else{
                $subir['promocion'] = 0;
            }



              
            unset($subir['userfile']);
            unset($subir['idProducto']);
            $result = $this->productos_model->editar_producto($subir, $idProducto);  


            $tipo = (!$result)? 'error': 'exito';
            $msj .= (!$result)? 'Error al Editar el Producto': ' Producto Editado correctamente';

            $mensaje = $this->mensaje_flash($tipo, $msj);
            $this->session->set_flashdata('correcto', $mensaje);
           

            redirect('/productos/listado','refresh');
        } else{
            $data['producto'] = $this->productos_model->datos_producto($id)->row_array();
            $data['categorias'] = $this->productos_model->listar_categorias();
            $data['subcategorias'] = $this->productos_model->listar_subcategorias();
            $this->load->view('admin/productos/v_editar_producto', $data);
        }

    }

	public function eliminar_categoria(){
	    $id = $this->input->post('idCategoria');
        $data['deleted_at'] = date("Y-m-d H:i:s");  
        $result = $this->productos_model->editar_categoria($data, $id); 
        echo $result;

	}


    public function eliminar_producto(){
        $id = $this->input->post('idProducto');
        $data['deleted_at'] = date("Y-m-d H:i:s");  
        $result = $this->productos_model->editar_producto($data, $id); 
        echo $result;

    }


	public function do_upload() {
        
        $config['upload_path'] = './uploads/productos';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '3000';
        $config['max_width'] = '2024';
        $config['max_height'] = '2008';
 
        $this->load->library('upload', $config);
        //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA UPLOAD_VIEW
        if (!$this->upload->do_upload()) {
            return  array(
                'error' => $this->upload->display_errors(),
                'tipo'  => 'error',
                'mensaje' => 'Error al cargar imagen',
            );
           
        } else {
            return  array(
                'tipo'  => 'exito',
                'mensaje' => 'Imagen cargada',
            );
        //EN OTRO CASO SUBIMOS LA IMAGEN, CREAMOS LA MINIATURA Y HACEMOS 
        //ENVÍAMOS LOS DATOS AL MODELO PARA HACER LA INSERCIÓN
            // $file_info = $this->upload->data();
            // //USAMOS LA FUNCIÓN create_thumbnail Y LE PASAMOS EL NOMBRE DE LA IMAGEN,
            // //ASÍ YA TENEMOS LA IMAGEN REDIMENSIONADA
            // $this->_create_thumbnail($file_info['file_name']);
            // $data = array('upload_data' => $this->upload->data());
            
            
            //$this->load->view('productos/v_categorias', $data);
        }
        
    }

    
}