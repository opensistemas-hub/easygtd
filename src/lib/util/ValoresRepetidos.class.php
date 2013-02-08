<?php
#esta funcion toma todo el contenido de un array y toma todos los valores repetidos, los cuenta y al final
#entrega un nuevo array sin valores repetidos y el numero total de incidencias de ese valor
#y los devuelve con index "value" para los valores sin repetir y "count" para el numero de incidencias
class ValoresRepetidos{
    static private $instance=null;

    static function getInstance(){
    	if(self::$instance == null){
    		self::$instance = new ValoresRepetidos();
    	}
    	return self::$instance;
    }
    private function __construct(){

    }

    function elementosRepetidos($array)
    {
        $repeated = array();


        foreach( (array)$array as $value )
        {
            $inArray = false;

        foreach( $repeated as $i => $rItem )
        {
            if( $rItem['value'] === $value )
            {
                $inArray = true;
                ++$repeated[$i]['count'];
            }
        }

        if( false === $inArray )
        {
            $i = count($repeated);
            $repeated[$i] = array();
            $repeated[$i]['value'] = $value;
            $repeated[$i]['count'] = 1;
        }
    }


    foreach( $repeated as $i => $rItem )
    {
        if($rItem['count'] === 1)
        {
            //unset($repeated[$i]);
        }
    }

    //sort($repeated);

    return $repeated;

}

}