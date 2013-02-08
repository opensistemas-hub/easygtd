<?php
abstract class StuffManagement{
      protected $dao = null;

    public function __construct(StuffDao $dao){
         $this->dao = $dao;
    }
    abstract public function find($id = -1);
    abstract public function save(Stuff $stuff);
    abstract public function search(CriterioDeBusqueda $criterioDeBusqueda);
    abstract public function delete(Stuff $stuff);
}