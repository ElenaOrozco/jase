<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ferfunc {

    public function correo($to, $subject, $body) {
        require_once "Mail.php";
        $from = "Soporte Sistema RS <rssoportesys14@gmail.com>";
//        $to = $Correo_Envio;
//        $subject = $Titulo;
//        $body = $Mensaje;

        $host = 'ssl://smtp.gmail.com';
        $port = "465";
        $username = "rssoportesys14@gmail.com";
        $password = "rssoportesys14.";

        $headers = array('From' => $from,
            'To' => $to,
            'Subject' => $subject);
        $smtp = Mail::factory('smtp', array('host' => $host,
                    'port' => $port,
                    'auth' => true,
                    'username' => $username,
                    'password' => $password));

        $mail = $smtp->send($to, $headers, $body);

        if (PEAR::isError($mail)) {
            echo("<p>" . $mail->getMessage() . "</p>");
        } else {
            echo("<p>Message successfully sent!</p>");
        }
    }

    public function correo_mime($from, $to, $subject, $body) {
        require_once "Mail.php";
        require_once 'Mail/mime.php';

        $host = 'ssl://smtp.gmail.com';
        $port = "465";
        $username = "rssoportesys14@gmail.com";
        $password = "rssoportesys14.";

        $text = 'Text version of email';
        $html = '<html><body>HTML version of email</body></html>';
        $file = '/home/richard/example.php';
        $crlf = "\n";
        $hdrs = array(
            'From' => 'you@yourdomain.com',
            'Subject' => 'Test mime message'
        );

        $mime = new Mail_mime(array('eol' => $crlf));

        $mime->setTXTBody($text);
        $mime->setHTMLBody($html);
        $mime->addAttachment($file, 'text/plain');

        $body = $mime->get();
        $hdrs = $mime->headers($hdrs);

        $mail = & Mail::factory('mail');
        $mail->send('postmaster@localhost', $hdrs, $body);
    }

    public function codificar($cadena) {
        return urlencode(base64_encode("Interbin" . $cadena));
    }

    public function decodificar($cadena) {
        return str_replace("Interbin", "", base64_decode(urldecode($cadena)));
    }

    public function get_permiso($id, $permiso) {
        $CI = & get_instance();
        // Verificar si es SUPERUSUARIO
        $qUser = $CI->db->get_where("catUsuarios", array("id" => $id));
        $aUser = $qUser->row_array();
        if ($aUser['SuperUsuario'] == 1) {
            return true;
        }

        $query = $CI->db->get_where('catUsuariosPermisos', array('idUsuario' => $id, 'Perfil' => $permiso, 'Estatus' => 1));
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function fechacas($date) {
        if (is_null($date) || $date == "" || $date == "1900-01-01" || $date == "0000-00-00") {
            return "";
        }
        $fecha_array = explode("-", $date);
        $meses_array = array("01" => "Ene", "02" => "Feb", "03" => "Mar", "04" => "Abr", "05" => "May", "06" => "Jun", "07" => "Jul", "08" => "Ago", "09" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dic");
        $fecha = $fecha_array[2] . "-" . $meses_array[$fecha_array[1]] . "-" . $fecha_array[0];
        return $fecha;
    }

    public function datetimecas($datetime) {
        if (is_null($datetime) || $datetime == "" || $datetime == "1900-01-01 00:00:00" || $datetime == "0000-00-00 00:00:00") {
            return "";
        }
        $eDateTime = explode(" ", $datetime);
        $date = $eDateTime[0];
        $time = $eDateTime[1];
        $fecha_array = explode("-", $date);
        $meses_array = array("01" => "Ene", "02" => "Feb", "03" => "Mar", "04" => "Abr", "05" => "May", "06" => "Jun", "07" => "Jul", "08" => "Ago", "09" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dic");
        $fecha = $fecha_array[2] . "-" . $meses_array[$fecha_array[1]] . "-" . $fecha_array[0];
        $hora_array = explode(":", $time);
        if ($hora_array[0] > 12) {
            $hora_array[0] = $hora_array[0] - 12;
            $Meridiano = "PM";
        } elseif ($hora_array[0] == 0) {
            $hora_array[0] = 12;
            $Meridiano = "AM";
        } elseif ($hora_array[0] == 12) {
            $Meridiano = "PM";
        } else {
            $Meridiano = "AM";
        }
        $hora = $hora_array[0] . ":" . $hora_array[1] . " " . $Meridiano;

        return $fecha . " " . $hora;
    }

    public function fechacascompleta($date) {
        if (is_null($date) || $date == "" || $date == "0000-00-00" || $date == "1900-01-01") {
            return "";
        }
        $fecha_array = explode("-", $date);
        $meses_array = array("01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");
        $fecha = $fecha_array[2] . " de " . $meses_array[$fecha_array[1]] . " de " . $fecha_array[0];
        return $fecha;
    }

    public function uppercases($string) {
        $string = strtoupper($string);
        $string = str_replace("�", "Á", $string);
        $string = str_replace("é", "É", $string);
        $string = str_replace("í", "Í", $string);
        $string = str_replace("�", "Ó", $string);
        $string = str_replace("ú", "Ú", $string);
        $string = str_replace("ü", "Ü", $string);
        $string = str_replace("ñ", "Ñ", $string);
        return $string;
    }

    public function display_relativo($identificador, $tabla, $campollave, $camporetorno, $tipollave, $tiporetorno) {
        if (!isset($identificador)) {
            switch ($tiporetorno) {
                case 'long':
                case 'int':
                    $cadenaretorno = 0;
                    break;
                case 'currency':
                    $cadenaretorno = "$ 0.00";
                    break;
                case 'date':
                case 'text':
                    $cadenaretorno = "";
                    break;
            }
        } else {
            $this->db->where($campollave, $identificador);
            $this->db->select($camporetorno);
            $query = $this->db->get($tabla, 1);

            if ($query->num_rows() != 1) {
                $row = $query->row_array();

                if ($tiporetorno == 'currency') {
                    $temp_number = 0;
                    $temp_number = $row[$camporetorno];
                    $cadenaretorno = '$ ' . number_format((float) $temp_number, 2, '.', ',');
                } else {
                    $cadenaretorno = $row[$camporetorno];
                }
            } else {
                switch ($tiporetorno) {
                    case 'long':
                    case 'int':
                        $cadenaretorno = 0;
                        break;
                    case 'currency':
                        $cadenaretorno = "$ 0.00";
                        break;
                    case 'text':
                        $cadenaretorno = "";
                        break;
                }
            }
            $query->free_result();
        }
        return $cadenaretorno;
    }

    public function numerosaletras($ad_cantidad, $ai_moneda) {
        $ls_salida = "(";
        $ls_enteros = number_format((int) $ad_cantidad, 0, '.', '');
        $ls_decimales = number_format($ad_cantidad, 2, '.', '');
        $ls_decimales = $ls_decimales[strlen($ls_decimales) - 2] . $ls_decimales[strlen($ls_decimales) - 1];

        if (strlen($ls_enteros) > 14) {
            return '';
        }

        if (intval($ls_enteros) == 0) {
            $ls_salida = $ls_salida . 'CERO';
        } else {
            $ls_salida = $ls_salida . $this->num2letras($ls_enteros, false, false);
        }

        if (intval($ls_enteros) == 1) {
            if ($ai_moneda == 1) {
                $ls_salida = $ls_salida . ' PESO ';
            } else {
                $ls_salida = $ls_salida . ' DOLLAR AMERICANO ';
            } //end if
        } else {
            if ($ai_moneda == 1) {
                $ls_salida = $ls_salida . ' PESOS ';
            } else {
                $ls_salida = $ls_salida . ' DOLLARES AMERICANOS ';
            } //end if
        } //end if

        if ($ai_moneda == 1) {
            $ls_salida = $ls_salida . $ls_decimales . '/100 M.N.)';
        } else {
            $ls_salida = $ls_salida . $ls_decimales . '/100 USD.)';
        } //end if

        return $ls_salida;
    }

    public function num2letras($num, $fem = true, $dec = true) {
        if (strlen($num) > 14)
            die("El n?mero introducido es demasiado grande");
        $matuni[2] = "dos";
        $matuni[3] = "tres";
        $matuni[4] = "cuatro";
        $matuni[5] = "cinco";
        $matuni[6] = "seis";
        $matuni[7] = "siete";
        $matuni[8] = "ocho";
        $matuni[9] = "nueve";
        $matuni[10] = "diez";
        $matuni[11] = "once";
        $matuni[12] = "doce";
        $matuni[13] = "trece";
        $matuni[14] = "catorce";
        $matuni[15] = "quince";
        $matuni[16] = "dieciseis";
        $matuni[17] = "diecisiete";
        $matuni[18] = "dieciocho";
        $matuni[19] = "diecinueve";
        $matuni[20] = "veinte";
        $matunisub[2] = "dos";
        $matunisub[3] = "tres";
        $matunisub[4] = "cuatro";
        $matunisub[5] = "quin";
        $matunisub[6] = "seis";
        $matunisub[7] = "sete";
        $matunisub[8] = "ocho";
        $matunisub[9] = "nove";

        $matdec[2] = "veint";
        $matdec[3] = "treinta";
        $matdec[4] = "cuarenta";
        $matdec[5] = "cincuenta";
        $matdec[6] = "sesenta";
        $matdec[7] = "setenta";
        $matdec[8] = "ochenta";
        $matdec[9] = "noventa";
        $matsub[3] = 'mill';
        $matsub[5] = 'bill';
        $matsub[7] = 'mill';
        $matsub[9] = 'trill';
        $matsub[11] = 'mill';
        $matsub[13] = 'bill';
        $matsub[15] = 'mill';
        $matmil[4] = 'millones';
        $matmil[6] = 'billones';
        $matmil[7] = 'de billones';
        $matmil[8] = 'millones de billones';
        $matmil[10] = 'trillones';
        $matmil[11] = 'de trillones';
        $matmil[12] = 'millones de trillones';
        $matmil[13] = 'de trillones';
        $matmil[14] = 'billones de trillones';
        $matmil[15] = 'de billones de trillones';
        $matmil[16] = 'millones de billones de trillones';

        $num = trim((string) @$num);
        if ($num[0] == '-') {
            $neg = 'menos ';
            $num = substr($num, 1);
        }
        else
            $neg = '';
        while ($num[0] == '0')
            $num = substr($num, 1);
        if ($num[0] < '1' or $num[0] > 9)
            $num = '0' . $num;
        $zeros = true;
        $punt = false;
        $ent = '';
        $fra = '';
        for ($c = 0; $c < strlen($num); $c++) {
            $n = $num[$c];
            if (!(strpos(".,'''", $n) === false)) {
                if ($punt)
                    break;
                else {
                    $punt = true;
                    continue;
                }
            } elseif (!(strpos('0123456789', $n) === false)) {
                if ($punt) {
                    if ($n != '0')
                        $zeros = false;
                    $fra .= $n;
                }
                else
                    $ent .= $n;
            }
            else
                break;
        }
        $ent = '     ' . $ent;
        if ($dec and $fra and !$zeros) {
            $fin = ' coma';
            for ($n = 0; $n < strlen($fra); $n++) {
                if (($s = $fra[$n]) == '0')
                    $fin .= ' cero';
                elseif ($s == '1')
                    $fin .= $fem ? ' una' : ' un';
                else
                    $fin .= ' ' . $matuni[$s];
            }
        }
        else
            $fin = '';
        if ((int) $ent === 0)
            return 'Cero ' . $fin;
        $tex = '';
        $sub = 0;
        $mils = 0;
        $neutro = false;
        while (($num = substr($ent, -3)) != '   ') {
            $ent = substr($ent, 0, -3);
            if (++$sub < 3 and $fem) {
                $matuni[1] = 'una';
                $subcent = 'as';
            } else {
                $matuni[1] = $neutro ? 'un' : 'uno';
                $subcent = 'os';
            }
            $t = '';
            $n2 = substr($num, 1);
            if ($n2 == '00') {
                
            } elseif ($n2 < 21)
                $t = ' ' . $matuni[(int) $n2];
            elseif ($n2 < 30) {
                $n3 = $num[2];
                if ($n3 != 0)
                    $t = 'i' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            }else {
                $n3 = $num[2];
                if ($n3 != 0)
                    $t = ' y ' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            }
            $n = $num[0];
            if ($n == 1) {
                $t = ' ciento' . $t;
            } elseif ($n == 5) {
                $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
            } elseif ($n != 0) {
                $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
            }
            if ($sub == 1) {
                
            } elseif (!isset($matsub[$sub])) {
                if ($num == 1) {
                    $t = ' mil';
                } elseif ($num > 1) {
                    $t .= ' mil';
                }
            } elseif ($num == 1) {
                $t .= ' ' . $matsub[$sub] . 'on';
            } elseif ($num > 1) {
                $t .= ' ' . $matsub[$sub] . 'ones';
            }
            if ($num == '000')
                $mils++;
            elseif ($mils != 0) {
                if (isset($matmil[$sub]))
                    $t .= ' ' . $matmil[$sub];
                $mils = 0;
            }
            $neutro = true;
            $tex = $t . $tex;
        }
        $tex = $neg . substr($tex, 1) . $fin;
        return strtoupper($tex);
    }

    public function nombretemporal($dir, $prefix) {
        $name = $prefix . md5(time() . rand());
        return $dir . '/' . $name;
    }

    public function xml2array($xml) {
        $parser = xml_parser_create('UTF-8'); // UTF-8 or ISO-8859-1
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $xml, $values);
        xml_parser_free($parser);

        $return = array();
        $stack = '';
        $attrs = array();
        $levelCounters = array(0);
        foreach ($values as $val) {
            if ($val['type'] == "open") {
                $ind = array_pop($levelCounters);
                $stack = $stack . "." . $val['tag'] . $ind;
                if ($val['attributes']) {
                    foreach ($val['attributes'] as $attrKey => $attrVal)
                        $return[$attrKey] = $attrVal;
                }
                array_push($levelCounters, $ind + 1);
                array_push($levelCounters, 0);
            } elseif ($val['type'] == "close") {
                $stack = substr($stack, 0, strrpos($stack, '.'));
            } elseif ($val['type'] == "complete") {
                $ind = array_pop($levelCounters);
                $stack = $val['tag'];
                if ($val['attributes']) {
                    foreach ($val['attributes'] as $attrKey => $attrVal)
                        $return[$attrKey] = $attrVal;
                }
                $return[$stack] = $val;
                $stack = substr($stack, 0, strrpos($stack, '.'));
                array_push($levelCounters, $ind + 1);
            }
        }
        return $return;
    }

    public function fecha_contrato($date) {
        $Fecha = strtotime($date);
        if ($Fecha === FALSE) {
            return 'No hay Fecha';
        }
        $dia = date('d', $Fecha);
        $mes = date('m', $Fecha);
        $anio = date('Y', $Fecha);

        $meses_array = array("01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");

        $FechaConvertida = (string) $dia;
        $FechaConvertida .= ' (' . $this->num2letras($dia, false, false);
        $FechaConvertida .= ') de ' . $meses_array[$mes];
        $FechaConvertida .= ' de ' . $anio;
        $FechaConvertida .= ' (' . $this->num2letras($anio, false, false) . ')';


        return $FechaConvertida;
    }

    public function hora_contrato($hora) {
        $eHora = explode(":", $hora);
        $Horas = $this->num2letras($eHora[0]);
        $Minutos = $this->num2letras($eHora[1]);
        return $hora . " (" . $Horas . ":" . $Minutos . ") horas";
    }

    public function DiferenciaFechasDias($fecha1, $fecha2) {
        $fecha1 = new DateTime($fecha1);
        $fecha2 = new DateTime($fecha2);
        if ($fecha1 < $fecha2) {
            $fecha = $fecha1->diff($fecha2);
            $dias = $fecha->format('%a');
        } else {
            $dias = 0;
        }
        return $dias;
    }

    public function Porcentaje($cantidad, $total) {
        $porcent = $cantidad / $total * 100;
        return $porcent;
    }

    public function formato_dinero($cantidad) {
        $retorno = "";
        if ($cantidad < 0) {
            $retorno .= '<span style="color: red;">';
        }
        $retorno .= "$ " . number_format($cantidad, 2);
        if ($cantidad < 0) {
            $retorno .= '</span>';
        }
        return $retorno;
    }

    function secondsToTime($seconds) {
        $dtF = new DateTime("@0");
        $dtT = new DateTime("@$seconds");  
        
        if ($seconds < 86400){
            $salida = $dtF->diff($dtT)->format(' %h:%i:%s');
        } else {
            $salida = $dtF->diff($dtT)->format(' %a dias, %h:%i:%s');
        }
        return $salida;
    }

    
    public function get_permiso_edicion_lectura($id, $pantalla, $permiso) {
        $CI = & get_instance();
// Verificar si es SUPERUSUARIO
        /*
          $qUser = $CI->db->get_where("catUsuarios", array("id" => $id));
          $aUser = $qUser->row_array();
          if ($aUser['SuperUsuario'] == 1) {
          return true;
          } */

        $query = $CI->db->get_where('saaUsuarioPermisos', array('idUsuario' => $id, 'Permiso' => $pantalla, 'Estatus' => 1));

        if ($query->num_rows() > 0) {
            $aPermiso = $query->row_array();
            
            $pos = strpos($aPermiso['Permisos'], $permiso);
            
                    
            if ($pos === false) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

   public function get_reg($table,$where,$select = "*"){        
        $CI = & get_instance();
        $CI->db->select($select);       
        $query = $CI->db->get_where($table,$where);
        if ($query->num_rows() > 0){
            return $query->row_array();
        } else {
            return false;
        }
    }
    
  public function get_subreg($tabla, $aWhere, $campos = 0,$ordenar=0){
        $CI = & get_instance();
        if ($campos !== 0){
            $CI->db->select($campos);
        }
        if ($ordenar !== 0){
            $CI->db->order_by($ordenar, "asc");
        }
        
        
        $qQuery = $CI->db->get_where($tabla,$aWhere);
        return  $qQuery;
    }  
    
    public function get_subreg_distinct($tabla, $aWhere, $campo ){
        $CI = & get_instance();
        $sql = 'SELECT DISTINCT '. $campo .' FROM '.$tabla.' WHERE '.$aWhere; 
        $query = $CI->db->query($sql);
        return $query;
   }  
   
   public function get_reg_libre($consulta ){
        $CI = & get_instance();
        $sql = $consulta; 
        $query = $CI->db->query($sql);
        return $query;
   }  
    
    
    
}

/* End of file Someclass.php */