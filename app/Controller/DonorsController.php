<?php class DonorsController extends AppController {
    
     public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    
    function index(){
        $this->layout = 'MainLayout';
        $this->set('loadedModule','donorsGrid');
        $this->render('/Modules/Donors');
    }
    
    function view($id = null) {
        $this->layout = 'MainLayout';
        $this->set('loadedModule','donorView');
       // $this->autoRender = false;
        
        if (!empty($id)){
            $donor = $this->Donor->find('first',[
                'conditions'=>['Donor.id'=>$id]
            ]);
            $this->set('donor',$donor);
        }
        
       // return json_encode($donor);
    }
    
    function getDonors(){
        $this->layout = false;
        $this->autoRender = false;
        
        $donors = $this->Donor->find('all');
       
        return json_encode($donors);
    }
    
    function edit($id = null){
        
        $this->layout = false;
        $this->autoRender = false;
        
        if (empty($this->request->data)){
            $response['success'] = false;
            $response['message'] = 'Empty data sent!';
            return json_encode($response);
        }
        
        if (empty($this->request->data['Donor_id'])){
            $this->Donor->create();
        } else {
            $saveData['Donor']['id'] = $this->request->data['Donor_id'];
        }
        
        $saveData['Donor']['name'] = trim($this->request->data['Donor_name']);
        $saveData['Donor']['address'] = trim($this->request->data['Donor_address']);
        $saveData['Donor']['contact_name'] = trim($this->request->data['Donor_contact_name']);
        $saveData['Donor']['contact_number'] = trim($this->request->data['Donor_contact_number']);
        $saveData['Donor']['contact_mail'] = trim($this->request->data['Donor_contact_mail']);
        $saveData['Donor']['contact_oib'] = trim($this->request->data['Donor_contact_oib']);
        $saveData['Donor']['gender'] = trim($this->request->data['Donor_gender']);
        $saveData['Donor']['weight'] = trim($this->request->data['Donor_weight']);
        
        $date_of_birth = date_create_from_format('d.m.Y',$this->request->data['Donor_date_of_birth']); 
        $saveData['Donor']['date_of_birth'] = $date_of_birth->format('Y-m-d');
        
        $saveData['Donor']['vaccinated'] = $this->request->data['Donor_vaccinated'];
        $saveData['Donor']['microchipped'] = $this->request->data['Donor_microchipped'];
        
        //to do
        //$saveData['Donor']['last_modified_by'] = AuthComponent::user('id');
        
        if ($this->Donor->saveAll($saveData)){
            $response['success'] = true;
            $response['message'] = __('Donor successfully saved.');
        } else {
            $response['success'] = false;
            $response['message'] = __('Error while saving. Please contact your Administrator.');

        }
    
        return json_encode($response);
    }
    
    function delete(){
        $this->layout = false;
        $this->autoRender = false;
       
        if (empty($this->request->data['donor_id'])){
            $response['success'] = false;
            $response['message'] = 'Empty id sent!';
            return json_encode($response);
        }
        
       // $this->User->id = $this->request->data['user_id'];
        if ($this->Donor->delete($this->request->data['donor_id'])){
            $response['success'] = true;
            $response['message'] = __('Yessss! Gone!');
        } else {
           $response['success'] = false;
            $response['message'] = __('Error deleting donor.'); 
        }
        
        return json_encode($response);
    }
    
    function search(){
        $this->layout = 'MainLayout';
        $this->set('loadedModule','donorSearch');
        $this->render('/Modules/Donors');
    }
}