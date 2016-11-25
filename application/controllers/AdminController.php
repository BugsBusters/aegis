<?php

class AdminController extends Zend_Controller_Action
{

    protected $_gestioneutenteForm = null;

    protected $_creautenteForm = null;

    protected $idUtente = null;

    public function init()
    {
        $this->_authService = new Application_Service_Auth();

        $this->_helper->layout->setLayout('layout');

        $this->idUtente = $this->_getParam('idutente'); //riceve il parametro dalla url
        if($this->hasParam("idutente"))
            $this->view->form = $this->modificautenteAction();

        $this->user = $this->_authService->getAuth()->getIdentity()->current();
        $notificheModel = new Application_Model_NotificaModel();

        $this->elenconotifiche = $notificheModel->getNotifichebyIdUtente($this->user->idutente);
        $this->view->assign("elenconotifiche",$this->elenconotifiche);
        $this->view->assign('role',$this->user->ruolo);

        $this->view->modificaprofiloform = $this->getModificaProfiloForm();

        $this->view->creautenteform = $this->getCreaUtenteForm(); //crea utente
    }

    public function indexAction()
    {
        // action body
    }

    public function notificheAction()
    {
        $notificheModel = new Application_Model_NotificaModel();

        $arraynotifiche = $notificheModel->getNotifichebyIdUtente($this->user->idutente);
        
        $this->view->arraynotifiche = $arraynotifiche;
        $this->view->utente = $this->user->username;

    }

    public function modificaprofiloAction()
    {
        // action body
    }

    public function getModificaProfiloForm()
    {
        $this->modificaprofiloform = new Application_Form_Modificaprofilo();
        $this->view->modificaform = $this->modificaprofiloform;

        $form = $this->modificaprofiloform;
        $usermodel=new Application_Model_UtenteModel();
        $dati=$usermodel->getUserByUser($this->user->username)->toArray();
        $form->populate($dati[0]);

        $urlHelper = $this->_helper->getHelper('url');

        $this->view->modificaform->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'verificamodificaprofilo'),
            'default'));
    }

    public function verificamodificaprofiloAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('modificaprofilo');
        }
        $form = $this->modificaprofiloform;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('modificaprofilo');
        } else {
            $datiform=$form->getValues();
            $username = $this->user->username;
            $utentimodel=new Application_Model_UtenteModel();

            if($utentimodel->existUsername($datiform['username']) && $datiform['username'] != $username) //controllo se l'username inserito esiste già nel db
            {
                $form->setDescription('Attenzione: l\'username che hai scelto non è disponibile.');
                return $this->getActionController()->render('modificadatiutente');
            }
            $authservice = new Application_Service_Auth();
            $authservice->getAuth()->getIdentity()->current()->username = $datiform['username'];

            $utentimodel->updateUtente($datiform, $username);
            $this->getHelper('Redirector')->gotoSimple('index','user',$module=null);

        }
    }

    public function gestioneutentiAction()
    {
        $modelUtenti = new Application_Model_UtenteModel();
        $elenco_utenti = $modelUtenti->getAll();
        $this->view->assign("elenco_utenti",$elenco_utenti);
    }

    public function eliminautenteAction()
    {
        $modelUtenti = new Application_Model_UtenteModel();
        $modelUtenti->elimina($this->idUtente);
        $this->_helper->redirector('gestioneutenti');
    }

    public function getModificaUtenteForm()
    {

        $urlHelper = $this->_helper->getHelper('url');
        $usermodel=new Application_Model_UtenteModel();

        //$id = $this->getParam('idutente');


            $dati = $usermodel->getUtenteById($this->getParam("idutente"));

                $this->_gestioneutenteForm = new Application_Form_Modificaprofilo();

             $this->_gestioneutenteForm->populate($dati->current()->toArray());

            $this->_gestioneutenteForm->setAction($urlHelper->url(array(
                'controller' => 'admin',
                'action' => 'verificamodificautente'),
                'default'
            ));

            return $this->_gestioneutenteForm;

    }

    public function modificautenteAction()
    {
        return $this->getModificaUtenteForm();
    }

    public function verificamodificautenteAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('modificautente');
        }
        $form = $this->_gestioneutenteForm;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('modificautente');
        } else {
            $datiform = $form->getValues();
            $utentimodel = new Application_Model_UtenteModel();
            $user = $this->_getParam('idutente');
            $utentimodel->modifica($datiform,$user);
            $this->getHelper('Redirector')->gotoSimple('gestioneutenti', 'admin', $module = null);
        }
    }

    public function getCreaUtenteForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_creautenteForm = new Application_Form_Modificaprofilo();

        $this->_creautenteForm->setAction($urlHelper->url(array(
            'controller' => 'admin',
            'action' => 'verificanuovoutente'),
            'default'
        ));

        return $this->_creautenteForm;
    }

    public function inserisciutenteAction()
    {
    }

    public function verificanuovoutenteAction(){
        $request = $this->getRequest();
        if(!$request->isPost()){
            return $this->_helper->redirector('gestisciutenti');
        }
        $form = $this->_creautenteForm;
        if(!$form->isValid($request->getPost())){
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('inserisciutente');
        }else{

            $datiform=$this->_creautenteForm->getValues(); //datiform è un array

            $utentimodel=new Application_Model_UtenteModel();

            $username = $datiform["username"];
            
            if($utentimodel->existUsername($username)) //controllo se l'username inserito esiste già nel db
            {
                $form->setDescription('Attenzione: l\'username che hai scelto non è disponibile.');
                return $this->render('inserisciutente');
            }
            else{
                $utentimodel->inserisci($datiform);
                $this->getHelper('Redirector')->gotoSimple('gestioneutenti','admin', $module = null);
            }
        }
    }


}











