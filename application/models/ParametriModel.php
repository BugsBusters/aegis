<?php

class Application_Model_ParametriModel
{

    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Parametri();
    }

    public function getparam()
    {
        $sql = $this->_tabella->select();
        return $this->_tabella->fetchAll($sql);
    }

    public function inserisci($dati){
        
        return $this->_tabella->insert($dati);
    }
    
    public function modificaById($dati,$id){
        
        return $this->_tabella->update($dati,"idparametro = ".$id);
    }

    public function modifica($dati){
        return $this->_tabella->update($dati);
    }

    public function modificaargomento($dati, $id){
        return $this->_tabella->update($dati, "argomento =".$id);
    }
    
    public function elimina($id){
        
        return $this->_tabella->delete("idparametri = ".$id);
    }


}

