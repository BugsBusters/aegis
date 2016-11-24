<?php

class Application_Model_PossessoModel
{

    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Possesso();
    }

    public function getpossessobyid($id)
    {

        $tabella = new Application_Model_DbTable_Possesso();
        $array = $this->fetchAll($tabella->select()->where("idpossesso = " . $id));
        return $array;

    }

    public function inseriscipossesso($dati)
    {
        return $this->insert($dati);

    }

    public function modificapossesso($dati, $id)
    {
        return $this->update($dati, "idpossesso =" . $id);
    }

    public function eliminapossesso($id)
    {
        return $this->delete("idpossesso =" . $id);

    }
}