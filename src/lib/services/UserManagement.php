<?php
abstract class UserManagement{
    protected $dao = null;

    public function __construct(UserDao $dao){
         $this->dao = $dao;
    }
    abstract public function find($id = -1);
    abstract public function save(User $user);
    abstract public function search(CriterioDeBusqueda $criterioDeBusqueda);
}