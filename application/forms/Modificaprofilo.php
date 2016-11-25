<?php

class Application_Form_Modificaprofilo extends App_Form_Abstract
{
    protected $_nome;
    protected $_cognome;
    protected $_username;
    protected $_password;



    public function init()
    {
        $this->setMethod('post');
        $this->setName('modificaprofilo'); //setta name e id del form


        $this->addElement('text', 'nome', array(
            'filters' => array('StringTrim'),
            'required' => true,
            'label' => 'Nome',
            'class' => 'form-control',
            'value' => $this->_nome,


        ));

        $this->addElement('text', 'cognome', array(
            'filters' => array('StringTrim'),
            'required' => true,
            'label' => 'Cognome',
            'class' => 'form-control',
            'value' => $this->_cognome,


        ));


        $this->addElement('text', 'username', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(2, 64))
            ),
            'required' => true,
            'label' => 'Username',
            'class' => 'form-control',
            'value' => $this->_username,


        ));

        $this->addElement('password', 'password', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(2, 64))
            ),
            'required' => true,
            'placeholder' => 'Inserisci la password',
            'label' => 'Password',
            'class' => 'form-control',
            'value' => $this->_password,
        ));


        $this->addElement('submit', 'invia', array(
            'class' => 'btn btn-rounded dropdown-toggle',
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'a', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }

        //include_once ('Lingua.php');

        public function populate($dati)
    {
        $this->nome->setValue($dati['nome']);
        $this->cognome->setValue($dati['cognome']);
        $this->username->setValue($dati['username']);
        $this->password->renderPassword = true;
        $this->password->setValue($dati['password']);
        
    }


}