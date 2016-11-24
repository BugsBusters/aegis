<?php

class Application_Model_UtenteModel
{
    protected $_tabella;


    public function __construct()
    {

        return $this->_tabella = new Application_Model_DbTable_Utente();
    }

    public function inserisci($dati)
    {

        return $this->_tabella->insert($dati);
    }

    public function getUserByUser($username)
    {
        $select = $this->select()
            ->where('username IN(?)', $username);
        return $this->fetchAll($select);
    }

    public function modifica($dati, $id)
    {
        return $this->_tabella->update($dati, "idutente = " . $id);
    }

    public function elimina($id)
    {
        return $this->_tabella->delete("idutente = " . $id);
    }

    public function loginUtente($username,$password){
        $sql = $this->_tabella->select()
                              ->where("username = ? ",$username)
                              ->where("password = ? ",$password);

        return $this->_tabella->fetchAll($sql);
    }
    
    
}

