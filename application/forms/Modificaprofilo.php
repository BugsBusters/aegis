<?php

class Application_Form_Modificaprofilo extends App_Form_Abstract
{


    public function init()
    {
        $this->setMethod('post');
        $this->setName('modificaprofilo'); //setta name e id del form



        $this->addElement('text', 'nome', array(
            'filters'    => array('StringTrim'),
            'required'   => true,
            'label'=> 'Nome',
            'class' =>'black-text',

        ));

        $this->addElement('text', 'cognome', array(
            'filters'    => array('StringTrim'),
            'required'   => true,
            'label'=> 'Cognome',
            'class' =>'black-text',

        ));
        

        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(2, 64))
            ),
            'required'         => true,
            'label'      => 'Username',
            'class' =>'black-text',

        ));

        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(2, 64))
            ),
            'required'         => true,
            'placeholder' => 'Inserisci la password',
            'label'      => 'Password',
            'class' =>'black-text',
            'value'=>$this->_password,
        ));


        $this->addElement('submit', 'modifica', array(
            'class' => 'btn waves-yellow green',
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'a', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));

        //include_once ('Lingua.php');
    }

}