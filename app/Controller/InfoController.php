<?php class InfoController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('index');
    }
    
    function conditions(){
        $this->layout = 'External';
    }
    
    function faq(){
          $this->layout = 'External';
    }
}