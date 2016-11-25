<?php

class Application_Model_TrappolaModel
{

    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Trappola();
    }

    public function gettrappolabyid($id)
    {
        return $this->_tabella->find($id);
    }

    public function getTrappolaByIdNodo($idnodo){
        $sql = $this->_tabella->select()->where("idnodo = ?",$idnodo);
        return $this->_tabella->fetchAll($sql);
    }

    public function inseriscitrappola($dati)
    {
        return $this->insert($dati);

    }

    public function modificatrappola($dati, $id)
    {
        return $this->update($dati, "idtrappola =" . $id);

    }

    public function eliminatrappola($id)
    {
        return $this->delete("idtrappola =" . $id);

    }

    public function getTrappole()
    {
        return $this->_tabella->fetchAll();
    }

    public function getTrappolaMedia()
    {
        $trappola = $this->getTrappole();
        $somma = 0;
        foreach ($trappola as $dato){
            $somma += $dato->conta;
        }
        return ($somma/count($trappola));

    }

    public function getTrappolaGrafico($idnodo)
    {
        //dati = [[new Date(2016, 07, 01),6],[new Date(2016, 07, 02),5]]

        $elencoMosche = $this->getTrappolaByIdNodo($idnodo);
        $dati = "[";
        $totale = count($elencoMosche);
        $i = 1;
        foreach ($elencoMosche as $mosche) {

            $anno = substr($mosche->data, 0, 4);
            $mese = substr($mosche->data, 5, 2);
            $giorno = substr($mosche->data, 8, 2);
            if ($i < $totale)
                $stringaTemporanea = "[new Date($anno,$mese,$giorno),$mosche->conta],";
            else
                $stringaTemporanea = "[new Date($anno,$mese,$giorno),$mosche->conta]";
            $dati .= $stringaTemporanea;
            $i++;
        }
        $dati .= "]";
        return $dati;
    }
}