<?php

class Application_Model_NodoModel
{
    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Nodo();
    }
    
    public function inserisci($dati){
        
        return $this->_tabella->insert($dati);
    }
    
    public function modifica($dati,$id){
        
        return $this->_tabella->update($dati,"idnodo = " .$id);
    }
    
    public function elimina($id){
        
        return $this->_tabella->delete("idnodo = ".$id);
    }


}

