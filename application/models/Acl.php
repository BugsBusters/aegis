<?php

class Application_Model_Acl extends Zend_Acl
{
    public function __construct()
    {

        $this->addRole(new Zend_Acl_Role('unregistered'))
            ->add(new Zend_Acl_Resource('index'))
            ->add(new Zend_Acl_Resource('error'))
            ->add(new Zend_Acl_Resource('login'))
            ->allow('unregistered', array('index','error','login'));


        $this->addRole(new Zend_Acl_Role('user'), 'unregistered')
            ->add(new Zend_Acl_Resource('user'))
            ->allow('user', 'user');


        $this->addRole(new Zend_Acl_Role('admin'), 'unregistered')
            ->add(new Zend_Acl_Resource('admin'))
            ->allow('admin', 'admin');
    }
}