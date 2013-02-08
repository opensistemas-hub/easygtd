<?php
class StuffManagementImpl extends StuffManagement{
    public function find($id = -1){
        return $this->dao->find($id);
    }
    public function save(Stuff $stuff){
        return $this->dao->save($stuff);
    }
    public function search(CriterioDeBusqueda $criterioDeBusqueda){
        return $this->dao->search($criterioDeBusqueda);
    }

    public function delete(Stuff $stuff){
        return $this->dao->delete($stuff);
    }
}