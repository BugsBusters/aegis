<?php

class Application_Model_UlivetoModel
{

    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Uliveto();
    }

    public function getUliveti(){
        return $this->_tabella->fetchAll();
    }

    public function getulivetobyid($id)
    {
       return $this->_tabella->find($id);
    }

    public function inserisciuliveto($dati)
    {
        return $this->_tabella->insert($dati);
    }

    public function modificauliveto($dati, $id)
    {
        return $this->_tabella->update($dati, "iduliveto = '$id'");
    }

    public function eliminauliveto($id)
    {
        return $this->_tabella->delete("iduliveto =  '$id'");
    }
}