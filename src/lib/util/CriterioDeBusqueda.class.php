<?php
class CriterioDeBusqueda {

	private $criterias;
	private $unico;
	private $criterias_compare;
	private $orderCriterias;
	private $limite = 0;
	private $agrupar;

	public function CriterioDeBusqueda(){
		$this->criterias = array();
		$this->unico = array();
		$this->orderCriterias = array();
	   	$this->criterias_compare = array();
	}

    /**
     * Alias del objeto.valor
     *
     *
     */
	public function agregar($index = '',$value = '',$compare = '='){
		$this->criterias[$index] = $value;
		$this->criterias_compare[$index] = $compare;
	}

	public function agregarOrden($index = 'id',$value = 'ASC'){
		$this->orderCriterias[$index] = $value;
	}

	public function limite($limite){
		$this->limite = $limite;
	}

	public function agrupar($value = ''){
		$this->agrupar[] = $value;
	}

	public function getAgrupar(){
		return $this->agrupar;
	}

	public function getLimite(){
		return $this->limite;
	}

	public function getUnico(){
		return $this->unico;
	}

	public function agregarUnico($index = 'id'){
		$this->unico[$index] = true;
	}

	public function getCriterioDeBusqueda($index){
		//TODO - HANDLE VALUE NOT SET
		$value = $this->criterias[$index];
		$value = trim($value);
        return $value;
	}

	public function getCriteriosDeBusqueda(){
		return $this->criterias;
	}

	public function getCriteriosDeOrden(){
		return $this->orderCriterias;
	}

	public function getCriteriosDeBusquedaComparacion(){
		return $this->criterias_compare;
	}

    /**
     *
     * @deprecated
     */
	public function noMinimalCriterias(){
		/*
		$long = 0;
		foreach ($this->criterias as $index => $value){
             $long = $long + strlen($value);
		}
		 //There is no minimal characters to perform a query.
		 if ($long < sfConfig::get('app_MINIMAL_CHARS_CRITERIA') ) return true;
		 */
         return false;
	}

    public function parsearOrden(){
      $data = "";
      foreach($this->orderCriterias as $order => $value) {
        $data .= '&orden-'.str_replace('.','-',$order).'='.$value;
        $data = strtolower($data);
      }
      return $data;
    }


}
?>
