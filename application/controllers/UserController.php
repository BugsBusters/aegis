<?php

class UserController extends Zend_Controller_Action
{

    protected $user = null;

    protected $_authService = null;

    protected $_nodoForm = null;

    public function init()
    {
        $this->_authService = new Application_Service_Auth();
        $this->user = $this->_authService->getAuth()->getIdentity()->current();

    }

    public function indexAction()
    {

        $olivetiModel = new Application_Model_UlivetoModel();
        $elencoOliveti = $olivetiModel->getUliveti();
        $this->view->elencoOliveti = $elencoOliveti;

        $idnodo = $this->getParam("nodo");
        $this->view->assign("currentPage", "index"); //mi serve per i grafici

        //dichiaro i model da usare
        $umiditaModel = new Application_Model_UmiditaModel();
        $temperaturaModel = new Application_Model_TemperaturaModel();
        $trappolaModel = new Application_Model_TrappolaModel();

        //dichiaro le medie

        $umiditaMedia = $umiditaModel->getUmiditaMedia();
        $temperaturaMedia = $temperaturaModel->getTemperaturaMedia();
        $contaMedia = $trappolaModel->getTrappolaMedia();

        //dichiaro i grafici



        $this->view->datiConta = $trappolaModel->getTrappolaGrafico($idnodo);

        //assegno i risultati alla view
        $this->view->assign("umidita", $umiditaMedia);
        $this->view->assign("temperatura", $temperaturaMedia);
        $this->view->assign("conta", $contaMedia);

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

  


}





















