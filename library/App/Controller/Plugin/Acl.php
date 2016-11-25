<?php

class App_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    protected $_acl;
    protected $_role;
    protected $_auth;

    public function __construct()
    {
        $this->_auth = Zend_Auth::getInstance();

        $this->_role = !$this->_auth->hasIdentity() ? 'unregistered' : $this->_auth->getIdentity()->current()->ruolo;
        
        $this->_acl = new Application_Model_Acl();


    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        echo $this->_role;
        if (!$this->_acl->isAllowed($this->_role, $request->getControllerName())) {
            $this->_auth->clearIdentity();
            $this->denyAccess();
        }
    }

    public function denyAccess()
    {

        $this->_request->setModuleName('default')
            ->setControllerName('index')
            ->setActionName('index');
    }
}
