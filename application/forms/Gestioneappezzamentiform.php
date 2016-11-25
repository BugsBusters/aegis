<?php


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
            'required' => true,
            'multiOptions' => $iduliveti,
            'class' => 'form-control'
        ));

        $this->addElement('submit', 'Aggiungi', array(
            'class' => 'btn btn-rounded dropdown-toggle',
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'a', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));



    }
}