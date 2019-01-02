<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Codeigniter: mpdf libraries
 * Tuesday, July, 19 2011
 * 
 * @author bang.webdeveloper@gmail.com
 */
require_once '/var/www/html/lib/MPDF57/mpdf.php';

class Pdf extends mPDF
{
    function __construct()
    {
        parent::__construct();
    }
}
?> 