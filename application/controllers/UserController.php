<?php

class UserController extends Zend_Controller_Action
{

    protected $modificaprofiloform;
    protected $user;
    protected $_authService;
    protected $elenconotifiche;
    protected $_formsensori;

    protected $_nodoForm = null;

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
        $this->view->assign("ruolo",$this->user->ruolo);

        $this->_formsensori = $this->getFormsensori();
        $this->view->formsensori = $this->_formsensori;


    }

    public function indexAction()
    {

        $olivetiModel = new Application_Model_UlivetoModel();
        $elencoOliveti = $olivetiModel->getUliveti();
        $this->view->elencoOliveti = $elencoOliveti;


        //dichiaro i model da usare
        $umiditaModel = new Application_Model_UmiditaModel();
        $temperaturaModel = new Application_Model_TemperaturaModel();
        $trappolaModel = new Application_Model_TrappolaModel();

        //dichiaro le medie

        $umiditaMedia = $umiditaModel->getUmiditaMedia();
        $temperaturaMedia = $temperaturaModel->getTemperaturaMedia();
        $contaMedia = $trappolaModel->getTrappolaMedia();

        //assegno i risultati alla view
        $this->view->assign("umidita", $umiditaMedia);
        $this->view->assign("temperatura", $temperaturaMedia);
        $this->view->assign("conta", $contaMedia);

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


    public function visualizzaappezzamentiAction()
    {
        if ($this->hasParam("uliveto")) {
            $appezzamentoModel = new Application_Model_AppezzamentoModel();
            $this->view->elencoAppezzamenti = $appezzamentoModel->getAppezzamentoByUliveto($this->getParam("uliveto"));
        } else
            $this->redirect(array("index", "user"));
    }

    public function visualizzanodiAction()
    {
        if ($this->hasParam("uliveto") && $this->hasParam("appezzamento")) {
            $nodoModel = new Application_Model_NodoModel();
            $this->view->elencoNodi = $nodoModel->getNodoByAppezzamento($this->getParam("appezzamento"));
        } else
            //
            return;
    }

    public function visualizzanodoAction()
    {
        if($this->hasParam("nodo")) {

            $idnodo = $this->getParam("nodo");
            $this->view->assign("currentPage", "index"); //mi serve per i grafici

            $umiditaModel = new Application_Model_UmiditaModel();
            $temperaturaModel = new Application_Model_TemperaturaModel();
            $trappolaModel = new Application_Model_TrappolaModel();


            $datiTemperatura = $temperaturaModel->getTemperaturaGrafico($idnodo);
            $datiUmidita = $umiditaModel->getUmiditaGrafico($idnodo);
            $datiTrappola = $trappolaModel->getTrappolaGrafico($idnodo);
            $this->view->datitemperatura = $datiTemperatura;
            $this->view->datiUmidita = $datiUmidita;
            $this->view->datiConta = $datiTrappola;
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




}



