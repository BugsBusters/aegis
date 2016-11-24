<?php

class Application_Model_UmiditaModel
{
    protected $_tabella;

    public function __construct()
    {
        return $this->_tabella = new Application_Model_DbTable_Umidita();
    }

    public function getumiditabyid($id)
    {
        $tabella = new Application_Model_DbTable_Umidita();
        $array = $this->fetchAl($tabella->select()->where("idumidita =" . $id));
        return $array;
    }

    public function inserisciumidita($dati)
    {
        return $this->insert($dati);
    }

    public function modificaumidita($dati, $id)
    {
        return $this->update($dati, "idumidita =" . $id);
    }

    public function eliminaumidita($id)
    {
        return $this->delete("idumidita =" . $id);
    }

    public function getUmidita(){
        return $this->_tabella->fetchAll();
    }

    public function getUmiditaMedia(){
        //inizializzo somma e umidità. Umidità contiene l'elenco delle umidità
        $umidità = $this->getUmidita();
        $somma = 0;
        //sommo tutte le percentuali di umidita
        foreach ($umidità as $dato){
            $somma += $dato->umidita;
        }
        //divido le somme per il numero di campioni
        $media = $somma / count($umidità);
        return $media;
    }

    public function getUmiditaGrafico()
    {
        //dati = [[new Date(2016, 07, 01),6],[new Date(2016, 07, 02),5]]

        $elencoUmidita = $this->getUmidita();
        $dati = "[";
        $totale = count($elencoUmidita);
        $i = 1;
        foreach ($elencoUmidita as $umidita) {

            $anno = substr($umidita->data, 0, 4);
            $mese = substr($umidita->data, 5, 2);
            $giorno = substr($umidita->data, 8, 2);
            if ($i < $totale)
                $stringaTemporanea = "[new Date($anno,$mese,$giorno),$umidita->umidita],";
            else
                $stringaTemporanea = "[new Date($anno,$mese,$giorno),$umidita->umidita]";
            $dati .= $stringaTemporanea;
            $i++;
        }
        $dati .= "]";
        return $dati;
    }
}

