<?php class AdminController extends AppController {
    
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }
    
    function checkPerm(){
        $this->layout = false;
        $this->autoRender = false;
        
        $result =  $this->Acl->check('Admins', 'donors', 'read');
        
        return $result;
    }
    
    function index(){
       $this->layout = 'admin';
       $this->set('modules',
               'usersTab,
                clinicsTab,
                permissionsTab,
                competitionsTab,
                eventsTab,
                alliancesTab,');
        
   }
   
    public function addAco() {
        $this->layout = false;
        $this->autoRender = false;
        //create aco controller
        //$this->Acl->Aco->create(array('parent_id' => 1, 'alias' => 'get'));
        //create aco actions
        $this->Acl->Aco->create(array('parent_id' => 4, 'alias' => 'getDonors'));
         
        
        if ($this->Acl->Aco->save()){
            return 'Success!';
        } else {
            return 'Failed :(';
        }
   }
   
   function addPerm(){
       $this->layout = false;
       $this->autoRender = false;
       $this->Acl->allow('Users', 'homepage/home');

   }
}