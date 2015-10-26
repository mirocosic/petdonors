<?php class GroupsController extends AppController {
    
    var $uses = ['Group'];

    function add(){
        
        if ($this->request->is('post')) {
            $this->Group->create();
            if ($this->Group->save($this->request->data)) {
                $this->Session->setFlash(__('The group has been saved'));
                return $this->redirect(array('action' => 'view'));
            }
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        }
        
    }
    
    function view(){
        $groups = $this->Group->find('all');
        $this->set('groups',$groups);
    }
    
    function delete(){
        
    }
    
}
