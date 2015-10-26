<?php class TestController extends AppController {
    
    var $uses = ['User','Group'];
    
    public function beforeFilter() {
        parent::beforeFilter();
      //  $this->Auth->allow(); // We can remove this line after we're finished
    }
    
    function index(){
      
    }
    
    public function test(){
        $this->autoRender = false;
       
    }
}