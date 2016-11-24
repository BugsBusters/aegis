<?php
class Application_Form_Index_Auth_Login extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        $this->setName('login');

        $this->setAction('');


        $this->addElement ('text','username',array(
            'filters'=> array('StringTrim'),
            'required' => true,
            'label' => 'username',
            'class'=> 'form-control',
        ));

        $this->addElement('password','password', array(
            'filters'=> array('StringTrim'),
            'required' => true,
            'label' => 'password',
            'class'=> 'form-control',
        ));


        $this->addElement('submit', 'Accedi', array(
            'label'    => 'Login',
            'class' => 'btn btn-rounded dropdown-toggle',
        ));
    }

}
