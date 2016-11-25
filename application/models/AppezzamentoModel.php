<?php

class Application_Model_AppezzamentoModel
{

    protected $_tabella;

    public function __construct()
    {

        return $this->_tabella = new Application_Model_DbTable_Appezzamento();
    }

    public function inserisci($dati){

        return $this->_tabella->insert($dati);
    }

    public function modifica($dati, $id)
    {

        return $this->_tabella->update($dati, "idappezzamento = " . $id);
    }

    public function elimina($id)
    {
        return $this->_tabella->delete("idappezzamento = " . $id);
    }

    public function getAppezzamentoByUliveto($iduliveto)
    {
        $sql = $this->_tabella->select()
                              ->where("iduliveto = ?",$iduliveto);
        return $this->_tabella->fetchAll($sql);
    }

    public function getAppezzamentoById($id){
        return $this->_tabella->find($id);
    }

    public function getAppezzamenti(){
        return $this->_tabella->fetchAll();
    }

    public function getAppezzamentoById($idappezz){
        $sql = $this->_tabella->select()
            ->where("idappezzamento = ?", $idappezz);

        return $this->_tabella->fetchAll($sql);
    }
}

