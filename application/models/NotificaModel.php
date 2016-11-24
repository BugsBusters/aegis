<?php

class Application_Model_NotificaModel
{

    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Notifica();
    }
    
    public function inserisci($dati){
        
        return $this->_tabella->insert($dati);
    }
    
    public function modifica($dati,$id){
        
        return $this->_tabella->update($dati, "idnotifica = ".$id);
    }
    
    public function elimina($id){
        
        return $this->_tabella->delete("idnotifica = ".$id);
    }

    public function getNotifichebyIdUtente($idUtente){
        $sql = $this->_tabella->select()
            ->where('idutente = ?', $idUtente)
            ->order('data desc')
            ->order('ora desc');
        return $this->_tabella->fetchAll($sql);
    }

    
}

