<?php

class Application_Model_CheckcomponentiModel
{
    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Checkcomponenti();
    }

    public function getCheck()
    {
        $sql= $this->_tabella->select();
        return $this->_tabella->fetchAll($sql);
    }

}

