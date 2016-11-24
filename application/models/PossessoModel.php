<?php

class Application_Model_PossessoModel
{

    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Possesso();
    }

    public function getpossessobyid($id)
    {

        $tabella = new Application_Model_DbTable_Possesso();
        $array = $this->fetchAll($tabella->select()->where("idpossesso = " . $id));
        return $array;

    }

    public function inseriscipossesso($dati)
    {
        return $this->insert($dati);

    }

    public function modificapossesso($dati, $id)
    {
        return $this->update($dati, "idpossesso =" . $id);
    }

    public function eliminapossesso($id)
    {
        return $this->delete("idpossesso =" . $id);

    }

    public function getcomponentemalfunz()
    {
        $s = 0;
        $sql = $this->_tabella->select()
            ->where("stato = ?", $s);


        $comp = $this->_tabella->fetchAll($sql);

        $nodimodel = new Application_Model_NodoModel();
        $appezzamentimodel = new Application_Model_AppezzamentoModel();
        $ulivetimodel = new Application_Model_UlivetoModel();
        $componentimodel = new Application_Model_ComponenteModel();


        $nodi = $nodimodel->getNodi()->toArray();
        $appez = $appezzamentimodel->getAppezzamenti()->toArray();
        $uliv = $ulivetimodel->getuliveti();
        //$comp = $componentimodel->getComponenteById($comp->idcomponente);



    }
}