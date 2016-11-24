<?php

class UserController extends Zend_Controller_Action
{

    protected $modificaprofiloform;
    protected $user;
    protected $_authService;
    protected $elenconotifiche;

    public function init()
    {
        $this->_helper->layout->setLayout('layout');

        $this->_authService = new Application_Service_Auth();
        $this->user=$this->_authService->getAuth()->getIdentity()->current();

        //passo il parametri delle notifiche sul layout per la casellina delle notifiche
        $notificheModel = new Application_Model_NotificaModel();
        $this->elenconotifiche = $notificheModel->getNotifichebyIdUtente($this->user->idutente);
        $this->view->assign("elenconotifiche",$this->elenconotifiche);
        $this->view->assign('role',$this->user->ruolo);

        $this->view->modificaprofiloform = $this->getModificaProfiloForm();



    }

    public function indexAction()
    {
        
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

    public function getModificaProfiloForm() {
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
    
    public function verificamodificaprofiloAction(){
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

}





