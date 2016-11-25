<?php

class Application_Model_NodoModel
{
    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Nodo();
    }

    public function contaNodi(){
        return $this->_tabella->fetchAll($this->_tabella->select()
            ->from("nodo", array("num"=>"COUNT(*)")))->current();
    }

    public function inserisci($dati)
    {

        return $this->_tabella->insert($dati);
    }

    public function modifica($dati, $id)
    {

        return $this->_tabella->update($dati, "idnodo = " . $id);
    }

    public function elimina($id)
    {

        return $this->_tabella->delete("idnodo = " . $id);
    }

    public function getNodoByAppezzamento($idappezzamento){
        $sql = $this->_tabella->select()->where("idappezzamento = ?",$idappezzamento);
        return $this->_tabella->fetchAll($sql);
    }

    public function getNodoById($id){
        $sql = $this->_tabella->select()->where("idnodo = ?",$id);
        return $this->_tabella->fetchAll($sql);
    }

    public function getNodi()
    {
        return $this->_tabella->fetchAll();
    }
}

