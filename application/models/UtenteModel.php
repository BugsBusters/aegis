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
        $select = $this->_tabella->select()
            ->where('username IN(?)', $username);
        return $this->_tabella->fetchAll($select);
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

    public function getUtenteById($id){
        $sql = $this->_tabella->select()
            ->where("idutente = ?", $id);


        return $this->_tabella->fetchAll($sql);

    }

    public function existUsername($username){
        $select=$this->_tabella->select()
            ->where('username=?',$username);

        $risultato = $this->_tabella->getAdapter()->query($select);

        if($risultato->rowCount()==0)
            $controllo = false;
        else $controllo = true;
        return $controllo;
    }
    
    public function updateUtente($dati, $username){
        $data = array(
            'username'      => $dati['username'],
            'nome'      => $dati['nome'],
            'cognome'      => $dati['cognome'],
            'password'      => $dati['password'],
        );
        $where = $this->_tabella->getAdapter()->quoteInto('username = ?', $username);

        $this->_tabella->update($data, $where);
    }
    
}

