<?php

class AdminController extends Zend_Controller_Action
{
    protected $_formappezzamenti;

    protected $user = null;

    protected $_authService = null;

    protected $elenconotifiche = null;

    public function init()
    {
        $this->_formappezzamenti = new Application_Form_Gestioneappezzamentiform();
        $this->view->formappezzamenti = $this->_formappezzamenti;
        $this->_authService = new Application_Service_Auth();

        $this->_helper->layout->setLayout('layout');
        $this->user = $this->_authService->getAuth()->getIdentity()->current();
        $notificheModel = new Application_Model_NotificaModel();

        $this->elenconotifiche = $notificheModel->getNotifichebyIdUtente($this->user->idutente);
        $this->view->assign("elenconotifiche",$this->elenconotifiche);
        $this->view->assign('role',$this->user->ruolo);

        $this->view->modificaprofiloform = $this->getModificaProfiloForm();
        $this->_helper->layout->setLayout('layout');
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



