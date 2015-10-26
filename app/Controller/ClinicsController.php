<?php class ClinicsController extends AppController {
    
    var $uses = ['Clinic','User','ClinicMembership'];
    
     public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = false;
        $this->autoRender = false;
    }
    
    function index(){
        $this->layout = 'MainLayout';
        $this->set('loadedModule','clinicsTab');
        $this->render('/Modules/Clinics');
    }
    
    public function getClinics(){
       
        $clinics = $this->Clinic->find('all',[
            'fields'=>['Clinic.id','Clinic.name','Clinic.address']
        ]);
      
        return json_encode($clinics);
        
    }
    
    function edit($id = null){
        if (empty($this->request->data)){
            $response['success'] = false;
            $response['message'] = 'Empty data sent!';
            return json_encode($response);
        }
        
        if (empty($this->request->data['Clinic_id'])){
            $this->Clinic->create();
        } else {
            $saveData['Clinic']['id'] = $this->request->data['Clinic_id'];
        }
        
        $saveData['Clinic']['name'] = trim($this->request->data['Clinic_name']);
        $saveData['Clinic']['address'] = trim($this->request->data['Clinic_address']);
       
        if ($this->Clinic->saveAll($saveData)){
            $response['success'] = true;
            $response['message'] = __('Clinic successfully saved.');
        } else {
            $response['success'] = false;
            $response['message'] = __('Error while saving. Please contact your Administrator.');

        }
    
        return json_encode($response);
    }
    
    function delete(){
        $response['success'] = true;
        $response['message'] = 'Yessss! Gone! Actually, this is not working yet ;)';
        return json_encode($response);
    }
    
    function getMembers(){
        if (empty($this->request->query['clinic_id'])){
            return json_encode(array('success'=>false,'message'=>'Clinic id empty'));
        }
        
        $result = $this->Clinic->find('first',[
            'conditions'=>['Clinic.id'=>$this->request->query['clinic_id']],
            'contain'=>['User']
        ]);
        
        return json_encode($result['User']);
       // debug($result['User']);
        
    }
    
    function addMember(){
        if (empty($this->request->data['clinic_id']) || empty($this->request->data['user_id'])){
            $response['success'] = false;
            $response['message'] = __('Please select a user');
            return json_encode($response);
        }
        
        
        
        $saveData['ClinicMembership']['user_id'] = $this->request->data['user_id'];
        $saveData['ClinicMembership']['clinic_id'] = $this->request->data['clinic_id'];
        
        if($this->ClinicMembership->save($saveData)){
            $response['success'] = true;
            $response['message'] = '';
        } else {
            $response['success'] = false;
            $response['message'] = __('Error while saving. Please contact your Administrator.');
        }
        return json_encode($response);
    }
    
    function removeMember(){
        if (empty($this->request->data['users_clinic_id'])){
            $response['success'] = false;
            $response['message'] = __('Please select a user');
            return json_encode($response);
        }
        
        if ($this->ClinicMembership->delete($this->request->data['users_clinic_id'])){
             $response['success'] = true;
            $response['message'] = '';
        } else {
            $response['success'] = false;
            $response['message'] = __('Unable to delete'); 
        }
         return json_encode($response);
    }
}