<?php

class Application_Model_UlivetoModel
{

    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Uliveto();
    }

    public function getulivetobyid($id)
    {
        $tabella = new Application_Model_UlivetoModel();
        $array = $this->fetchAll($tabella->select()->where("iduliveto =" . $id));
        return $array;
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