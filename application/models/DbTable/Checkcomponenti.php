<?php

class Application_Model_DbTable_Checkcomponenti extends Zend_Db_Table_Abstract
{

    protected $_name = 'checkcomponenti';
    protected $_primary = array('idcomponente','idnodo','idappezzamento', 'iduliveto');

}

