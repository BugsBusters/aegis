<?php

class AdminController extends Zend_Controller_Action
{
    protected $_formsensori;

    public function init()
    {
        $this->_formsensori = $this->getFormsensori();

        $this->view->formsensori = $this->_formsensori;


        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function notificheAction()
    {
        $notificheModel = new Application_Model_NotificaModel();
        $arraynotifiche = $notificheModel->getNotifiche();
        $idutente = $arraynotifiche[0]->idutente;

        $utenteModel = new Application_Model_UtenteModel();
        $utente = $utenteModel->getUtenteById($idutente)[0]->username;

        $this->view->arraynotifiche = $arraynotifiche;
        $this->view->utente = $utente;

    }

    public function getFormsensori()
    {

        $urlHelper = $this->_helper->getHelper('url');
        $formsensori = new Application_Form_Admin_Sensoriform();
        $param= new Application_Model_ParametriModel();
        $dati= $param->getparam()->toArray();
        $formsensori->populate($dati[0]);
        $formsensori->setAction($urlHelper->url(array(
                'controller' => 'admin',
                'action' => 'verificasensori')
        ));
        return $formsensori;
    }

    public function impostazionisensoriAction()
    {

    }

    public function verificasensoriAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost())
            return $this->_helper->redirector('impostazionisensori');
        $form = $this->_formsensori;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: Alcuni dati inseriti sono non corretti');
            return $this->render('impostazionisensori');
        } else {
            $dati = $this->_formsensori->getValues();
            $param= new Application_Model_ParametriModel();
            $param->modifica($dati);
            return $this->_helper->redirector('index');
        }
    }


    public function controllaParam($param)
    {
        $parametro = 0;
        if ($this->hasParam("$param"))
            $parametro = $this->getParam("$param");
        return $parametro;
    }


}



