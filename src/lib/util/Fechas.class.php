<?php
class Fechas {

  static private $instance=null;

    static function getInstance(){
    	if(self::$instance == null){
    		self::$instance = new Fechas();
    	}
    	return self::$instance;
    }
    private function __construct(){

    }
    
    
/**
*@param string $fecha => Las fechas deben venir en formato {12/12/2009} {12-12-2009} {2009-12-12}
*@param int $ndias => numero de dias para calcular. Pueden ser positivo(1) o negativos(-1)
*/
function suma_fechas($fecha,$ndias) {
            

      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            

              list($dia,$mes,$anio)=split("/", $fecha);
            

      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            

              list($dia,$mes,$anio)=explode("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$anio) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("Y-m-d",$nueva);
        
        
      if (preg_match("/([0-9][0-9]){1,2}-[0-9]{1,2}-[0-9]{1,2}/",$fecha))
            

              list($anio,$mes,$dia)=explode("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$anio) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("Y-m-d",$nueva);  
            

      return ($nuevafecha);  
            

  }
  
  public function restaFechas($fecha_inicial,$fecha_final){
  
      //defino fecha 1
      list($anio,$mes,$dia) = explode('-',$fecha_inicial);
      $ano1 = $anio;
      $mes1 = $mes;
      $dia1 = $dia;
      
      list($anio,$mes,$dia) = explode('-',$fecha_final);

      //defino fecha 2
      $ano2 = $anio;
      $mes2 = $mes;
      $dia2 = $dia;

      //calculo timestam de las dos fechas
      $timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
      $timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2);

      //resto a una fecha la otra
      $segundos_diferencia = $timestamp1 - $timestamp2;
      //echo $segundos_diferencia;

      //convierto segundos en días
      $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);

      //obtengo el valor absoulto de los días (quito el posible signo negativo)
      $dias_diferencia = abs($dias_diferencia);

      //quito los decimales a los días de diferencia
      $dias_diferencia = floor($dias_diferencia);
      
      return $dias_diferencia;


  
  }
/*
@param:
 $type: = discriminador de dias
   1: Lunes,miercoles y viernes.
   2: Martes y Jueves.
   3: Todos los dias.
   4: Una vez a la semana
   5: Una vez al mes
   6: Una vez al año
   
 $first_date = fecha actual o inicial
 $limit_date = ultima fecha donde se ejecutara
 $max_recurrence = tiempo en recursion en caso de que no exista $limit_date :: ver strtotime() que es funcion php
*/  
  public function recurrenceDates($type=3,$first_date,$limit_date=0,$max_recurrence='2Years'){
  
      $recurrence = $type;
      
      
      $return_dates = array();
      
      $row['fecha_inicial'] = $first_date;

      if ( strlen ($limit_date) > 1 ) {

        $row['fecha_final'] = $limit_date;

      } else {
      
        $row['fecha_final'] = date("Y-m-d", strtotime ($max_recurrence)); 
      
      }
      
      $restante = Fechas::getInstance()->restaFechas($row['fecha_inicial'],$row['fecha_final']);
     
      $row['fecha_resultado'] = $restante;

      //return all days on the recurrence
      for ($i = 0; $i<=$restante;$i++) {
        
       $date = date('D',strtotime(Fechas::getInstance()->suma_fechas($first_date,$i)));
       $dates = date('Y-m-d',strtotime(Fechas::getInstance()->suma_fechas($first_date,$i)));
        
        switch ($recurrence) {
          case 1:
            //init just mon,wed and fri
            
            if ($date == 'Mon' || $date == 'Wed' || $date == 'Fri') {
             $return_dates[] = $dates;
            }
            //end
          
            break;
          case 2:
          //init just tue and thu
            if ($date == 'Tue' || $date == 'Thu') {
              $return_dates[] = $dates;
            } 
          
          //end
          
            break;
          case 3:
            //everydays
            $return_dates[] = $dates;
            break;
          case 4:
            //init just once a week
            break;      
        
        }
        
             
        
      }
    
      return $return_dates;

  
  }
  
  // in case of week, month or years
  public function recurrenceForLapsus($type=4,$date_init,$date_end=0,$recurrence) {
  
    $date_booked = date('Y-m-d',strtotime($recurrence));
    
    $first_date = $date_init;
    $end_date = ($date_end != 0)?$date_end:$date_booked;
    
    
    $dates_array = array();
    $dates_array[]=$first_date;
    
    switch ($type) {
    //case week
      case 4:
        while($first_date < $end_date) {
      
            $first_date = $this->addWeek($first_date);
            
            if ($first_date < $end_date) {
              $dates_array[] = $first_date;
            } else {
              //DO NOTHING
            }
            
          
          }   
        break;
        
        case 5: 
        
          while($first_date < $end_date) {
      
            $first_date = $this->addMonth($first_date);
            
            if ($first_date < $end_date) {
              $dates_array[] = $first_date;
            } else {
              //DO NOTHING
            }
            
          
          }
        
          break;
          
        case 6:
          while($first_date < $end_date) {
      
            $first_date = $this->addMonth($first_date,12);
            
            if ($first_date < $end_date) {
              $dates_array[] = $first_date;
            } else {
              //DO NOTHING
            }
            
          
          }
        
        
          break;  
    
    }
    
    
    
    
    return $dates_array;
 
  
  }
  
  
  function addWeek ($fecha_inicial,$end_date=0) {
  
  
  $date_next_week = Fechas::getInstance()->suma_fechas($fecha_inicial,7);
  
  return $date_next_week;

  
  }
  
  function addMonth($fecha_inicial,$meses=1) {
    
    
     list($anio,$mes,$dia) = explode('-',$fecha_inicial);
     
     $tmpanio=floor($meses/12);
     $tmpmes=$meses%12;
     $anionew=$anio+$tmpanio;
     $mesnew=$mes+$tmpmes;

     if ($mesnew>12)
     {
      $mesnew=$mesnew-12;
      if ($mesnew<10)
       $mesnew="0".$mesnew;
      $anionew=$anionew+1;
     }
     

     $fecha=date( "Y-m-d", mktime(0,0,0,$mesnew,$dia,$anionew) );
     return $fecha;     
  
  }
  

  

}//END CLASS
