<?php

class Application_Form_Datinodo extends Zend_Form
{

    protected $_appezzamentiModel;
    public function init()
    {
        $this->setMethod('post');
        $this->setName('nodo'); //setta name e id del form

        $this->addElement('select', 'gprs', array(
            'multiOptions' => array('0' => 'Non montato', '1' => 'Montato'),
            'class' => 'form-control',
            'label' => 'GPRS:'
        ));
        $this->addElement('select', 'indice-posizione', array(
            'multiOptions' => array('A' => 'A', 'B' => 'B', 'C' => 'C',  'D' => 'D'),
            'class' => 'form-control',
            'label' => 'Indice di posizione:'
        ));

        $categories = array(); //dichiaro un array che conterrà le opzioni della select


        $this->_appezzamentiModel = new Application_Model_AppezzamentoModel(); //creo un istanza del model appezzamento.
        $cats = $this->_appezzamentiModel->getAppezzamenti(); //creo un array chiamato cats che conterrà tutti i appezzamenti

        foreach ($cats as $cat) {
            $categories[$cat->idappezzamento] = $cat['idappezzamento'];
        }
        $this->addElement('select', 'idappezzamento', array(
            'required' => true,
            'multiOptions' => $categories,
            'class' => 'form-control'
        ));

        $this->addElement('submit', 'Invia', array(
            'class' => 'btn btn-success btn-lg'
        ));
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }


}

