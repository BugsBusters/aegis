<?php

/**
 * Created by PhpStorm.
 * User: edoardo
 * Date: 25/11/2016
 * Time: 02:01
 */
class Application_Form_Gestioneappezzamentiform extends App_Form_Abstract
{


    public function init()
    {
        $this->setMethod('post');
        $this->setName('gestioneappezzamenti'); //setta name e id del form


        $this->addElement('text', 'note', array(
            'filters' => array('StringTrim'),
            'required' => true,
            'label' => 'Inserisci la nota dell\' appezzamento',
            'class' => 'form-control',

        ));
        $ulivetimodel = new Application_Model_UlivetoModel();
        $uliveti = $ulivetimodel->getUliveti();


        $iduliveti = array();
        foreach ($uliveti as $val) {
            $iduliveti[$val->iduliveto] = $val->descrizione;
        }


        $this->addElement('select', 'iduliveto', array(
            'label' => 'uliveto',
            'multiOptions' => $iduliveti,
        ));


    }
}