<?php

class Application_Model_TrappolaModel
{

    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Trappola();
    }

    public function gettrappolabyid($id)
    {
        $tabella = new Application_Model_DbTable_Trappola();
        $array = $this->fetchAll($tabella->select()->where("idtrappola =" . $id));
        return $array;
    }

    public function inseriscitrappola($dati)
    {
        return $this->insert($dati);

    }

    public function modificatrappola($dati, $id)
    {
        return $this->update($dati, "idtrappola =" . $id);

    }

    public function eliminatrappola($id)
    {
        return $this->delete("idtrappola =" . $id);

    }
}