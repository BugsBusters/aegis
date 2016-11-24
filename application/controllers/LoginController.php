<?php

class LoginController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_authService = new Application_Service_Auth();
        $this->_helper->layout->setLayout('layout');
        $this->view->loginForm = $this->getLoginForm();
        
    }

    public function indexAction()
    {

    }

    private function getloginform()
    {


        $login = new Application_Form_Index_Auth_Login();
        $this->view->login = $login;
        $urlHelper = $this->_helper->getHelper('url');

        $this->view->login->setAction($urlHelper->url(array(
            'controller' => 'login',
            'action' => 'authenticate'),
            'default'
        ));
    }
    

    public function authenticateAction()
    {

        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('index');
        }
        $form = $this->view->login;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('index');
        }
        if (false === $this->_authService->authenticate($form->getValues())) {
            $form->setDescription('Autenticazione fallita. Riprova');
            return $this->render('index');
        }


        return $this->getHelper('Redirector')->gotoSimple('index', $this->_authService->getIdentity()->current()->ruolo);
    }

    public function verificaregistraAction()
    {

        $request = $this->getRequest();
        if (!$request->isPost())
            return $this->_helper->redirector('registrautente');
        $form = $this->_registratiform;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: Alcuni dati inseriti sono non corretti');

            return $this->render('registrautente');
        } else {
            $datiform = $this->_registratiform->getValues();
            $utentimodel = new Application_Model_Utente();
            $username = $this->controllaParam('username');
            if ($utentimodel->existUser($username)) {
                $form->setDescription('Attenzione: l\'username che hai inserito è gia stato utilizzato! ');
                return $this->render('registrautente');
            } else {
                $utentimodel->insertUtente($datiform);
                $this->getHelper('Redirector')->gotoSimple('index', 'index', $module = null);
            }
        }

    }


    public function logoutAction()
    {
        //elimino l'identità del login e reindirizzo l'utente alla parte pubblica del sito
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index', 'index');
    }
}

