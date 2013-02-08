<?php
/**
 * Clase para almacenar las notificaciones de vista desde los servicios.
 *
 */
class Mensajes {

	static private $instance = NULL;
	private $errores;
	private $erroresMostrados;
	private $exitos;
	private $informaciones;
	private $limpiar = false;


	static function getInstance() {
	    if (self::$instance == NULL) {
    	    self::$instance = new Mensajes();
    	}
          return self::$instance;
	}

	private function __construct(){
	  	$this->errores = array();
	  	$this->erroresMostrados = array();
	  	$this->exitos = array();
	  	$this->informaciones = array();
	  	$this->limpiar = false;
	}

   public function getErrores(){
   	 return $this->errores;
   }

   public function getExitos(){
   	 return $this->exitos;
   }

   public function getInformaciones(){
   	 return $this->informaciones;
   }

   public function agregarError($msj){
   	 $this->errores[] = $msj;
   }

   public function notificarErrorMostrados($id = 0){
   	  $this->erroresMostrados[$id] = date('U');
   }

   public function errorYaMostrado($id = 0){
   	  return isset($this->erroresMostrados[$id]);
   }

   public function agregarExito($msj){
   	 $this->exitos[] = $msj;
   }

   public function agregarInformacion($code){
   	 $this->informaciones[] = $code;
   }

   public function getLimpiar(){
   	 return $this->limpiar;
   }

   public function setLimpiar($valor = false){
   	 $this->limpiar = $valor;
   }
   
   public function mezclar($mensajes){
   	
	foreach($mensajes->getErrores() as $error){
		$this->agregarError($error);
	}
		   	  
	foreach($mensajes->getExitos() as $exito){
		$this->agregarExito($exito);
	}
		   	  
	foreach($mensajes->getInformaciones() as $informacion){
		$this->agregarInformacion($informacion);
	}   

    
   	 $this->limpiar = $mensajes->getLimpiar();
   
	
   }
}