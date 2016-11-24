<?php

class Application_Model_ParametriModel
{

    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Parametri();
    }
    
    public function inserisci($dati){
        
        return $this->_tabella->insert($dati);
    }
    
    public function modifica($dati,$id){
        
        return $this->_tabella->update($dati,"idparametri = ".$id);
    }
    
    public function elimina($id){
        
        return $this->_tabella->delete("idparametri = ".$id);
    }


}

