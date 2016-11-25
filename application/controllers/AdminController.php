<?php

class AdminController extends Zend_Controller_Action
{
    private $_ulivetoform;
    private $_front;
    public function init()
    {
        $this->_helper->layout->setLayout('adminlayout');

        $this->_ulivetoform = new Application_Form_Aggiungiuliveto();
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

    public function elencoulivetiAction(){
        $model = new Application_Model_UlivetoModel();
        $uliveti = $model->getUliveti();
        $aggiungiulivetoform = new Application_Form_Aggiungiuliveto();
        $this->view->assign('listauliveti', $uliveti);
        
    }

    public function elencoappezzamentiAction(){
        $idUliveto = $this->getParam('id');
        $modelAppezz = new Application_Model_AppezzamentoModel();
        if(!is_null($idUliveto)){
            $appezzamenti = $modelAppezz->getAppezzamenti();
            $this->view->assign('appezzamenti', $appezzamenti);
        }
    }

    public function aggiungiulivetoAction(){
        $this->_ulivetoform->setAction(Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/validateuliveto');
        $this->view->assign('aggiungiform', $this->_ulivetoform);
    }
    public function validateulivetoAction(){
        $request = $this->getRequest();
        //istanzio la form di registrazione di un nuovo utente

        if (!$request->isPost()) {
            return $this->_helper->redirector('aggiungiuliveto');
        }

        $form = $this->_ulivetoform;

        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('aggiungiuliveto');
        }
        else
        {
            $datiform=$this->_ulivetoform->getValues();

            $ulivetomodel=new Application_Model_UlivetoModel();

                $ulivetomodel->inserisciuliveto($datiform);
                $this->getHelper('Redirector')->gotoSimple('elencouliveti','admin', $module = null);
        }

    }

    public function eliminaulivetoAction(){
        $id=$this->getParam('id');
        if (!is_null($id)){
            $ulivetomodel = new Application_Model_UlivetoModel();
            $ulivetomodel->eliminauliveto($id);
        }
        $this->getHelper('Redirector')->gotoSimple('elencouliveti','admin', $module = null);
    }

    public function modificaulivetoAction(){
        $request = $this->getRequest();
        if ($request->isGet()){
            $id = $this->getParam('id');
            $ulivetomodel = new Application_Model_UlivetoModel();
            $sql = $ulivetomodel->getulivetobyid($id)->current();
            $data = array('descrizione' => $sql->descrizione);
            $this->_ulivetoform->populate($data);
        }
        $this->_ulivetoform->setAction(Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/validateulivetomod/id/'.$id);
        $this->view->assign('aggiungiform', $this->_ulivetoform);
    }

    public function validateulivetomodAction(){
        $request = $this->getRequest();
        $id = $this->getParam('id');
        if (!$request->isPost()) {
            return $this->_helper->redirector('modificauliveto');
        }

        $form = $this->_ulivetoform;

        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('modificauliveto');
        }
        else
        {
            $datiform=$this->_ulivetoform->getValues();
            
            $ulivetomodel=new Application_Model_UlivetoModel();
           
            $ulivetomodel->modificauliveto($datiform, $id);
            $this->getHelper('Redirector')->gotoSimple('elencouliveti','admin', $module = null);
        }}

        public function inseriscinodoAction()
     {
         $this->_nodoForm = new Application_Form_Datinodo();
                    $this->_nodoForm->setAction($this->_helper->url->url(array(
                                'controller' => 'user',
                                'action' => 'inseriscinodopost',
                                'uliveto' => $this->getParam("uliveto"),
                                'appezzamento' => $this->getParam("appezzamento")
                                    ),
             'default'
                        ));
         return $this->_nodoForm;
     }

     public function inseriscinodopostAction()
     {
                    $request = $this->getRequest(); //vede se esiste una richiesta
                    if (!$request->isPost()) { //controlla che sia stata passata tramite post
                            return $this->_helper->redirector('inseriscinodo'); // se non c'è un passaggio tramite post, reindirizza all' inseriscicentroAction
         }
         $form=$this->_nodoForm;
         if (!$form->isValid($request->getPost())) {
                            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                            return $this->render('inseriscinodo');
         }
        $datiform=$form->getValues(); //datiform è un array
         $datiform['stato']=0;
         $datiform['indice-posizione']=$_POST['indiceposizione'];


        $nodoModel = new Application_Model_NodoModel();
        $nodoModel->inserisci($datiform);
        $params = array('uliveto' => $this->getParam("uliveto"), 'appezzamento' => $this->getParam("appezzamento"));
        $this->_helper->redirector('visualizzanodi','user' ,null, $params);
    }

   public function modificanodoAction()
   {
                   // action body
               }

    public function modificanodopostAction()
     {
                   // action body
              }

     public function eliminanodoAction()
     {
                   // action body
                }
    }
}



