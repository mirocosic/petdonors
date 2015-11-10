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
        $this->Acl->Aco->create(array('parent_id' => 6, 'alias' => 'home'));
        if ($this->Acl->Aco->save()){
            return 'Success!';
        } else {
            return 'Failed :(';
        }
   }
   
   function addPerm(){
       $this->layout = false;
       $this->autoRender = false;
       $this->Acl->allow('Users', 'homepage');

   }
}