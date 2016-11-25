<?php

class UserController extends Zend_Controller_Action
{

    protected $user = null;

    protected $_authService = null;

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


        $this->view->assign("currentPage", "index"); //mi serve per i grafici

        //dichiaro i model da usare
        $umiditaModel = new Application_Model_UmiditaModel();
        $temperaturaModel = new Application_Model_TemperaturaModel();
        $datiTemperatura = $temperaturaModel->getTemperaturaGrafico();
        $datiUmidita = $umiditaModel->getUmiditaGrafico();
        $this->view->datitemperatura = $datiTemperatura;
        $this->view->datiUmidita = $datiUmidita;

        $trappolaModel = new Application_Model_TrappolaModel();
        $this->view->datiConta = $trappolaModel->getTrappolaGrafico();

        //dati = [[new Date(2016, 07, 01),6],[new Date(2016, 07, 02),5]]


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
        $this->view->currentPage = "visualizzanodi";
        if($this->hasParam("appezzamento")){
            $appezzamentoModel = new Application_Model_AppezzamentoModel();
            $this->view->appezzamento = $appezzamentoModel->getAppezzamentoById($this->getParam("appezzamento"))->current();
        }
    }


}









