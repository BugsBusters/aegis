<?php

class Application_Model_UlivetoModel
{

    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Uliveto();
    }

    public function getUliveti(){
        $sql= $this->_tabella->select();
        return $this->_tabella->fetchAll($sql);
    }

    public function getulivetobyid($id)
    {

        $sql= $this->_tabella->select()->where("iduliveto = ?", $id);
        return $this->_tabella->fetchAll($sql);
    }

    public function inserisciuliveto($dati)
    {
        return $this->insert($dati);
    }

    public function modificauliveto($dati, $id)
    {
        return $this->update($dati, "iduliveto =" . $id);
    }

    public function eliminauliveto($id)
    {
        return $this->delete("iduliveto =" . $id);
    }
}