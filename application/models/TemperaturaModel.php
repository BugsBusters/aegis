<?php

class Application_Model_TemperaturaModel
{
    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Temperatura();
    }

    public function gettemperaturabyid($id)
    {
        return $this->_tabella->find($id);
    }

    public function inseriscitemperatura($dati)
    {
        return $this->insert($dati);

    }

    public function modificatemperatura($dati, $id)
    {
        return $this->update($dati, "idtemperatura =" . $id);
    }

    public function eliminatemperatura($id)
    {
        return $this->delete("idtemperatura =" . $id);
    }

    public function getTemperature()
    {
        return $this->_tabella->fetchAll();
    }

    public function getTemperaturaMedia()
    {
        $temperature = $this->getTemperature();
        $somma = 0;
        foreach ($temperature as $dato) {
            $somma += $dato->temperatura;
        }
        return ($somma / count($temperature));
    }

    public function getTemperaturaGrafico()
    {
        //dati = [[new Date(2016, 07, 01),6],[new Date(2016, 07, 02),5]]

        $elencoTemperature = $this->getTemperature();
        $dati = "[";
        $totale = count($elencoTemperature);
        $i = 1;
        foreach ($elencoTemperature as $temperatura) {

            $anno = substr($temperatura->data, 0, 4);
            $mese = substr($temperatura->data, 5, 2);
            $giorno = substr($temperatura->data, 8, 2);
            if ($i < $totale)
                $stringaTemporanea = "[new Date($anno,$mese,$giorno),$temperatura->temperatura],";
            else
                $stringaTemporanea = "[new Date($anno,$mese,$giorno),$temperatura->temperatura]";
            $dati .= $stringaTemporanea;
            $i++;
        }
        $dati .= "]";
        return $dati;
    }

}