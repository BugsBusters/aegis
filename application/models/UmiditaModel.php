<?php

class Application_Model_UmiditaModel
{
    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Umidita();
    }

    public function getumiditabyid($id)
    {
        $tabella = new Application_Model_DbTable_Umidita();
        $array = $this->fetchAl($tabella->select()->where("idumidita =" . $id));
        return $array;
    }

    public function inserisciumidita($dati)
    {
        return $this->insert($dati);
    }

    public function modificaumidita($dati, $id)
    {
        return $this->update($dati, "idumidita =" . $id);
    }

    public function eliminaumidita($id)
    {
        return $this->delete("idumidita =" . $id);
    }
}

