<?php class HomepageController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    
    function index(){
        $this->layout = 'MainLayout';
       // $this->autoRender = false;
        $this->set('loadedModule','');
        //echo 'This is Homepage!';
    }
}