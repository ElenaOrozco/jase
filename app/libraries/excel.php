

<?php

class Excel {

    private $excel;

    public function __construct() {
        // initialise the reference to the codeigniter instance
        require_once APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $this->excel = new PHPExcel();    
    }

    public function load($path,$version = 'Excel5') {
        $objReader = PHPExcel_IOFactory::createReader($version);
        $this->excel = $objReader->load($path);
    }

    public function save($path,$version = 'Excel5') {
        // Write out as the new file
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, $version);
        $objWriter->save($path);
    }

    public function stream($filename,$version = 'Excel5') {       
        header('Content-type: application/ms-excel');
        header("Content-Disposition: attachment; filename=\"".$filename."\""); 
        header("Cache-control: private");        
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, $version);
        $objWriter->save('php://output');    
    }

    public function  __call($name, $arguments) {  
        // make sure our child object has this method  
        if(method_exists($this->excel, $name)) {  
            // forward the call to our child object  
            return call_user_func_array(array($this->excel, $name), $arguments);  
        }  
        return null;  
    }  
}

?>