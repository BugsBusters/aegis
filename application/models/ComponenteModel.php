<?php

class Application_Model_ComponenteModel
{

    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Componente();
    }

    public function inserisi($dati)
    {

        return $this->_tabella->insert($dati);
    }

    public function modifica($dati, $id)
    {

        return $this->_tabella->update($dati, "idcomponente = " . $id);
    }

    public function elimina($id)
    {
        return $this->_tabella->delete("idcomponente = " . $id);
    }

    public function getComponenteById($idcomponente)
    {
        $sql = $this->_tabella->select()
            ->where("stato = ?", $idcomponente);

        return $this->_tabella->fetchAll($sql);
    }
}

