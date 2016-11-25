<?php

class AdminController extends Zend_Controller_Action
{
    protected $_formappezzamenti;

    public function init()
    {
        $this->_formappezzamenti = new Application_Form_Gestioneappezzamentiform();
        $this->view->formappezzamenti = $this->_formappezzamenti;

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

    public function gestionemalfunzionamentiAction()
    {
        $possessoModel = new Application_Model_CheckcomponentiModel();
        $this->view->componentimalfunz = $possessoModel->getCheck()->toArray();


    }

    public function gestioneappezzamentiAction()
    {
        $appezzamentimodel = new Application_Model_AppezzamentoModel();
        $this->view->elencoappezzamenti = $appezzamentimodel->getAppezzamenti();

        $ulivetimodel = new Application_Model_UlivetoModel();
        $uliveti = $ulivetimodel->getUliveti();



        //per far passare alla view la descrizione dell' uliveto
        $iduliveti = array();
        foreach ($uliveti as $val) {
            $iduliveti[$val->iduliveto] = $val->descrizione;
        }
        $this->view->desculiveti = $iduliveti;

    }


    public function aggiungiulivetoAction()
    {
        $this->_ulivetoform->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/admin/validateuliveto');
        $this->view->assign('aggiungiform', $this->_ulivetoform);
    }

    public function validateulivetoAction()
    {
        $request = $this->getRequest();
        //istanzio la form di registrazione di un nuovo utente

        if (!$request->isPost()) {
            return $this->_helper->redirector('aggiungiuliveto');
        }

        $form = $this->_ulivetoform;

        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('aggiungiuliveto');
        } else {
            $datiform = $this->_ulivetoform->getValues();

            $ulivetomodel = new Application_Model_UlivetoModel();

            $ulivetomodel->inserisciuliveto($datiform);
            $this->getHelper('Redirector')->gotoSimple('elencouliveti', 'admin', $module = null);
        }

    }

    public function eliminaulivetoAction()
    {
        $id = $this->getParam('id');
        if (!is_null($id)) {
            $appezzamentomodel = new Application_Model_AppezzamentoModel();
            $appezzamentomodel->elimina($id);
        }
        $this->getHelper('Redirector')->gotoSimple('gestioneappezzamenti', 'admin', $module = null);
    }


}



