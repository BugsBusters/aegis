<?php
class Application_Form_Aggiungiuliveto extends Zend_Form {

    protected $_utenteModel;
    protected $_numstanze;


    public function __construct()
    {

        $this->init();
    }


    public function init()
    {

        $this->setMethod('post');
        $this->setName('NuovoUliveto');


        $this->addElement ('text','descrizione',array(
            'filters'=> array('StringTrim'),
            'required' => true,
            
            'class'=> '  form-control',
        ));
        $this->addElement('submit', 'Aggiungi', array(
            'class' => 'btn white-text',
            'style' => 'margin:10px;background-color:#bfcc96;border-color:#5c6b4c'
        ));

/*
        $this->addElement('text', 'descrizione', array(
            'required' => true,
            'validators' => array(array('Alpha'))
        ));

        $this->addElement('submit', 'aggiungi', array(
            'class' => 'btn btn-large',
            'style' => 'margin:10px;background-color:#bfcc96;border-color:#5c6b4c'
        ));
*/
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));


    }
    


}