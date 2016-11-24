<?php

class Application_Model_TemperaturaModel
{
    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Temperatura();
    }

    public function gettemperaturabyid($id)
    {
        $tabella = new Application_Model_DbTable_Temperatura();
        $array = $this->fetchAll($tabella->select()->where("idtemperatura =" . $id));
        return $array;
    }

    public function inseriscitemperatura($dati)
    {
        return $this->insert($dati);

    }

    public function modificatemperatura($dati, $id)
    {
        return $this->update($dati, "idtemperatura =" . $id);
    }

    public function eliminatemperatura($id)
    {
        return $this->delete("idtemperatura =" . $id);
    }

}