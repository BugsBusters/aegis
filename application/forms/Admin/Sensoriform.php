<?php
class Application_Form_Admin_Sensoriform extends Zend_Form
{
    public function init()
    {
        $this->setMethod('Post');
        $this->setName('Sensore mosche');

        $this->addElement('text', 'mosche', array(
            'filters' => array('StringTrim'),
            'required' => true,
            'label' => 'Mosche',
            'class' => 'form-control',
            'validators' => array(array(
                'StringLength', true, array(2, 20),
            )),
        ));

        $this->addElement('text', 'temperatura', array(
            'filters' => array('StringTrim'),
            'required' => true,
            'label' => 'Temperatura',
            'class' => 'form-control',
            'validators' => array(array(
                'StringLength', true, array(2, 20),
            )),
        ));
        $this->addElement('text', 'umidita', array(
            'filters' => array('StringTrim'),
            'required' => true,
            'label' => 'Umidità',
            'class' => 'form-control',
            'validators' => array(array(
                'StringLength', true, array(2, 20),
            )),
        ));


        $this->addElement('submit', 'Inserisci', array(
            'label' => 'Inserisci',
            'class' => 'btn btn-primary',
        ));
    }
}
