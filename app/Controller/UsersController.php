<?php class UsersController extends AppController {
    
    var $uses = ['User','ClinicMembership'];
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login','logout','view');
    }
    
    public function login() {
         $this->layout = "login";
        if ($this->request->is('post')) {
            $this->autoRender = false;
            $this->layout = false;
            
            if ($this->Auth->login()) {
               // return $this->redirect($this->Auth->redirectUrl());
               $response['success'] = true;
               $response['message'] = 'Login successful!';
               $response['redirect'] = $this->Auth->redirectUrl();
               return json_encode($response);
            } else {
                $response['success'] = false;
                $response['message'] = 'Login failed!';
                return json_encode($response);
            }
           // $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }
    
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    
    function add(){
        
        App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
        $passwordHasher = new BlowfishPasswordHasher();
         
         
         if ($this->request->is('post')) {
            $this->User->create();
            $this->request->data['User']['password'] = $passwordHasher->hash($this->request->data['User']['password']);
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'view'));
            }
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        }
        
    }
    
    function edit($id = null){
        
        $this->layout = false;
        $this->autoRender = false;
        
        if (empty($this->request->data)){
            $response['success'] = false;
            $response['message'] = 'Empty data sent!';
            return json_encode($response);
        }
        
        if (empty($this->request->data['User_id'])){
            $this->User->create();
        } else {
            $saveData['User']['id'] = $this->request->data['User_id'];
        }
        
        $saveData['User']['name'] = trim($this->request->data['User_name']);
        $saveData['User']['surname'] = trim($this->request->data['User_surname']);
        $saveData['User']['mail'] = trim($this->request->data['User_mail']);
        $saveData['User']['username'] = trim($this->request->data['User_username']);
        $saveData['User']['oib'] = trim($this->request->data['User_oib']);
        
        if (!empty($this->request->data['User_password'])){
            App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
            $passwordHasher = new BlowfishPasswordHasher();
        
           $saveData['User']['password'] = $passwordHasher->hash($this->request->data['User_password']);
        }
        
        
        if ($this->User->saveAll($saveData)){
            $response['success'] = true;
            $response['message'] = __('User successfully saved.');
        } else {
            $response['success'] = false;
            $response['message'] = __('Error while saving. Please contact your Administrator.');

        }
    
        return json_encode($response);
    }
    
    function index(){
        $this->layout = 'MainLayout';
        $this->set('loadedModule','usersTab');
        $this->render('/Modules/Users');
    }
    
    function getUsers(){
        $this->layout = false;
        $this->autoRender = false;
        
        $users = $this->User->find('all',[
            'fields'=>['User.id','User.username','User.name','User.surname','User.mail','User.oib']
        ]);
       
        return json_encode($users);
        
    }
    
    function view($id = null){
        if ($id == null){
            throw new NotFoundException;
        }
        
        $user = $this->User->find('first',[
            'conditions'=>['User.id'=>$id]
        ]);
        
        if ($user){
            $this->set('user',$user);
        } else {
            throw new NotFoundException;
        }
    }
    
    function delete(){
        $this->layout = false;
        $this->autoRender = false;
       
        if (empty($this->request->data['user_id'])){
            $response['success'] = false;
            $response['message'] = 'Empty id sent!';
            return json_encode($response);
        }
        
       // $this->User->id = $this->request->data['user_id'];
        if ($this->User->delete($this->request->data['user_id'])){
            $response['success'] = true;
            $response['message'] = 'Yessss! Gone!';
        } else {
           $response['success'] = false;
            $response['message'] = 'Error deleting user.'; 
        }
        
        return json_encode($response);
    }
    
}