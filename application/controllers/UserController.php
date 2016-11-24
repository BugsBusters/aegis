<?php

class UserController extends Zend_Controller_Action
{

    protected $modificaprofiloform;
    protected $user;


    public function init()
    {
        $this->_helper->layout->setLayout('layout');
        $this->view->modificaprofiloform = $this->getModificaProfiloForm();
        $this->user=$this->_authService->getAuth()->getIdentity()->current()->username;

    }

    public function indexAction()
    {
        
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

    public function modificaprofiloAction()
    {
        // action body
    }

    public function getModificaProfiloForm() {
        $this->modificaprofiloform = new Application_Form_Modificaprofilo();
        $this->view->modificaprofilo = $this->modificaprofiloform;
        $urlHelper = $this->_helper->getHelper('url');

        $this->view->login->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'verificamodificaprofilo'),
            'default'));
    }
    
    public function verificamodificaprofiloAction(){
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('modificaprofilo');
        }
        $form = $this->modificaprofiloform;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('modificautente');
        } else {
            $datiform=$form->getValues();

            $username = $this->user;
            $utentimodel=new Application_Model_UtenteModel();

            if($utentimodel->existUsername($datiform['username']) && $datiform['username'] != $username) //controllo se l'username inserito esiste già nel db
            {
                $form->setDescription('Attenzione: l\'username che hai scelto non è disponibile.');
                return $this->getActionController()->render('modificadatiutente');
            }
            $authservice = new Application_Service_Auth();
            $authservice->getAuth()->getIdentity()->current()->username = $datiform['username'];
            $utentimodel->updateUtentiSet($datiform, $username);

        }
    }

}





