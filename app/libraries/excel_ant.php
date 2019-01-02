 <?php
  
 class Excel{
  
         function read_file($filename){
  
                 require_once 'Excel/reader.php';
  
                $data = new Spreadsheet_Excel_Reader();
                $data->setOutputEncoding('utf8');
                $data->read(realpath(APPPATH.'../files/'.$filename));
 
                 $datos = $data->sheets[0]['cells'];    

                 return $datos;        
                 }
  }