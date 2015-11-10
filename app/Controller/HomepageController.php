<?php class HomepageController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    
    function index(){
        $this->layout = 'External';
    }
    
    function home(){
        $this->layout = 'MainLayout';
        $this->set('loadedModule','');
    }
}