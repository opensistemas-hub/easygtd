<?php
class UserManagementImpl extends UserManagement{
    public function find($id = -1){
        return $this->dao->find($id);
    }
    public function save(User $user){
        return $this->dao->save($user);
    }
    public function search(CriterioDeBusqueda $criterioDeBusqueda){
        return $this->dao->search($criterioDeBusqueda);
    }
}