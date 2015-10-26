<?php class SettingsController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    
    function index(){
        $this->layout = 'MainLayout';
        $this->set('loadedModule','settings');
        

    }
}