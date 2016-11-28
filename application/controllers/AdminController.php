<?php

class AdminController extends Zend_Controller_Action
{
    protected $_formappezzamenti;

    protected $user = null;

    protected $_authService = null;

    protected $elenconotifiche = null;

    protected $_formsensori;

    private $_ulivetoform;
    private $_nodoform;

    public function init()
    {
        $this->_helper->layout->setLayout('adminlayout');
        $this->_nodoform = new Application_Form_Datinodo();
        $this->_ulivetoform = new Application_Form_Aggiungiuliveto();
        $this->view->nodoForm = $this->inseriscinodoAction();


        $this->_formsensori = $this->getFormsensori();

        $this->view->formsensori = $this->_formsensori;



        $this->view->formappezzamenti = $this->getFormAppezzamenti();
        $this->_authService = new Application_Service_Auth();

        $this->_helper->layout->setLayout('layout');
        $this->user = $this->_authService->getAuth()->getIdentity()->current();
        $notificheModel = new Application_Model_NotificaModel();

        $this->elenconotifiche = $notificheModel->getNotifichebyIdUtente($this->user->idutente);
        $this->view->assign("elenconotifiche",$this->elenconotifiche);
        $this->view->assign('role',$this->user->ruolo);

        $this->view->modificaprofiloform = $this->getModificaProfiloForm();
        $this->_helper->layout->setLayout('layout');
        $this->view->assign("ruolo",$this->user->ruolo);
    }

    public function indexAction()
    {
        $possessomodel = new Application_Model_PossessoModel();
        $nodimodel= new Application_Model_NodoModel();
        $contanodi = $nodimodel->contaNodi();
        $contarotti = $possessomodel->contaRotture();
        $this->view->assign('contanodi', $contanodi);
        $this->view->assign('contarotti', $contarotti);
    }

    public function notificheAction()
    {
        $notificheModel = new Application_Model_NotificaModel();
        $arraynotifiche = $notificheModel->getNotifiche();
        $idutente = $arraynotifiche[0]->idutente;

        $arraynotifiche = $notificheModel->getNotifichebyIdUtente($this->user->idutente);

        $this->view->arraynotifiche = $arraynotifiche;
        $this->view->utente = $this->user->username;

    }

    public function gestionemalfunzionamentiAction()
    {
        $possessoModel = new Application_Model_CheckcomponentiModel();
        $this->view->componentimalfunz = $possessoModel->getCheck()->toArray();


    }

    public function getFormAppezzamenti(){
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formappezzamenti = new Application_Form_Gestioneappezzamentiform();


        $this->_formappezzamenti->setAction($urlHelper->url(array(
            'controller' => 'admin',
            'action' => 'verificaaggiuntaappezzamento'),
            'default'));

        return $this->_formappezzamenti;
    }

    public function verificaaggiuntaappezzamentoAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('gestioneappezzamenti');
        }
        $form = $this->_formappezzamenti;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('gestioneappezzamenti');
        } else {
            $datiform = $form->getValues();

            $appezzamentoModel = new Application_Model_AppezzamentoModel();


            $appezzamentoModel->inserisci($datiform);
            $this->getHelper('Redirector')->gotoSimple('gestioneappezzamenti', 'admin', $module = null);

        }
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

    public function getModificaProfiloForm() {
        $this->modificaprofiloform = new Application_Form_Modificaprofilo();
        $this->view->modificaform = $this->modificaprofiloform;

        $form = $this->modificaprofiloform;
        $usermodel=new Application_Model_UtenteModel();
        $dati=$usermodel->getUserByUser($this->user->username)->toArray();
        $form->popolaForm($dati[0]);

        $urlHelper = $this->_helper->getHelper('url');

        $this->view->modificaform->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action' => 'verificamodificaprofilo'),
            'default'));
    }
/*
    public function aggiungiulivetoAction()
    {
        $this->_ulivetoform->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/admin/validateuliveto');
        $this->view->assign('aggiungiform', $this->_ulivetoform);
    }
*/
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

    public function eliminaappezzamentoAction()
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

    public function elencoulivetiAction()
    {
        $model = new Application_Model_UlivetoModel();
        $uliveti = $model->getUliveti();
        $aggiungiulivetoform = new Application_Form_Aggiungiuliveto();
        $this->view->assign('listauliveti', $uliveti);

    }

    public function elencoappezzamentiAction()
    {
        $idUliveto = $this->getParam('uliveto');
        $modelAppezz = new Application_Model_AppezzamentoModel();
        if (!is_null($idUliveto)) {
            $appezzamenti = $modelAppezz->getAppezzamenti();
            $this->view->assign('elencoAppezzamenti', $appezzamenti);
            $this->view->assign('uliveto', $idUliveto);
        }
    }

    public function aggiungiulivetoAction()
    {
        $this->_ulivetoform->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/admin/validateuliveto');
        $this->view->assign('aggiungiform', $this->_ulivetoform);
    }

    public function eliminaulivetoAction()
    {
        $id = $this->getParam('id');
        if (!is_null($id)) {
            $ulivetomodel = new Application_Model_UlivetoModel();
            $ulivetomodel->eliminauliveto($id);
        }
        $this->getHelper('Redirector')->gotoSimple('elencouliveti', 'admin', $module = null);
    }

    public function modificaulivetoAction()
    {
        $request = $this->getRequest();
        if ($request->isGet()) {
            $id = $this->getParam('id');
            $ulivetomodel = new Application_Model_UlivetoModel();
            $sql = $ulivetomodel->getulivetobyid($id)->current();
            $data = array('descrizione' => $sql->descrizione);
            $this->_ulivetoform->populate($data);
        }
        $this->_ulivetoform->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/admin/validateulivetomod/id/' . $id);
        $this->view->assign('aggiungiform', $this->_ulivetoform);
    }

    public function validateulivetomodAction()
    {
        $request = $this->getRequest();
        $id = $this->getParam('id');
        if (!$request->isPost()) {
            return $this->_helper->redirector('modificauliveto');
        }

        $form = $this->_ulivetoform;

        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('modificauliveto');
        } else {
            $datiform = $this->_ulivetoform->getValues();

            $ulivetomodel = new Application_Model_UlivetoModel();

            $ulivetomodel->modificauliveto($datiform, $id);
            $this->getHelper('Redirector')->gotoSimple('elencouliveti', 'admin', $module = null);
        }
    }

    public function inseriscinodoAction()
    {
        $this->_nodoForm = new Application_Form_Datinodo();
        $appezzamento = $this->getParam("appezzamento");
        $uliveto = $this->getParam("uliveto");
        $this->_nodoForm->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/admin/inseriscinodopost/uliveto/' . $uliveto . '/appezzamento/' . $appezzamento);
        return $this->_nodoForm;
    }

    public function inseriscinodopostAction()
    {
        $request = $this->getRequest(); //vede se esiste una richiesta
        if (!$request->isPost()) { //controlla che sia stata passata tramite post
            return $this->_helper->redirector('inseriscinodo'); // se non c'è un passaggio tramite post, reindirizza all' inseriscicentroAction
        }
        $form = $this->_nodoForm;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('inseriscinodo');
        }
        $datiform = $form->getValues(); //datiform è un array
        $datiform['statonodo'] = 0;
        $datiform['indice-posizione'] = $_POST['indiceposizione'];


        $nodoModel = new Application_Model_NodoModel();
        $nodoModel->inserisci($datiform);
        $this->redirect('/admin/visualizzanodi/uliveto/' . $this->getParam("uliveto") . '/appezzamento/' . $this->getParam("appezzamento"));
    }

    public function modificanodoAction()
    {
        $request = $this->getRequest();
        if ($request->isGet()) {
            $id = $this->getParam('nodo');
            $nodomodel = new Application_Model_NodoModel();
            $sql = $nodomodel->getNodoById($id)->current()->toArray();
            $this->_nodoform->populate($sql);
        }
        $appezzamento = $this->getParam("appezzamento");
        $uliveto = $this->getParam("uliveto");
        $this->_nodoform->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/admin/modificanodopost/uliveto/' . $uliveto . '/appezzamento/' . $appezzamento . '/id/' . $id);
        $this->view->assign('nodoform', $this->_nodoform);
    }

    public function modificanodopostAction()
    {

        $request = $this->getRequest();
        $id = $this->getParam('id');
        if (!$request->isPost()) {
            return $this->_helper->redirector('modificanodo');
        }

        $form = $this->_nodoform;

        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('modificanodo');
        } else {
            $datiform = $this->_nodoform->getValues();
            $datiform['indice-posizione'] = $_POST['indiceposizione'];
            $nodomodel = new Application_Model_NodoModel();

            $nodomodel->modifica($datiform, $id);
            //$params = array('uliveto' => $this->getParam("uliveto"), 'appezzamento' => $this->getParam("appezzamento"));
            $this->redirect('/admin/visualizzanodi/uliveto/' . $this->getParam("uliveto") . '/appezzamento/' . $this->getParam("appezzamento"));
        }
    }

    public function eliminanodoAction()
    {
        $id = $this->getParam('nodo');
        $nodomodel = new Application_Model_NodoModel();
        $nodomodel->elimina($id);
        $params = array('uliveto' => $this->getParam("uliveto"), 'appezzamento' => $this->getParam("appezzamento"));
        $this->_helper->redirector('visualizzanodi', 'admin', 0, $params);
    }

    public function visualizzanodiAction()
    {
        if ($this->hasParam("uliveto") && $this->hasParam("appezzamento")) {
            $nodoModel = new Application_Model_NodoModel();

            $this->view->elencoNodi = $nodoModel->getNodoByAppezzamento($this->getParam("appezzamento"));
        } else {
            $this->_helper->redirector('index', 'admin');
        }
        return;
    }

}



