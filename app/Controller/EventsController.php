<?php class EventsController extends AppController {
    
    var $uses = ['Event','Donor','EventMembership'];
    
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = false;
        $this->autoRender = false;
    }
    
    public function index(){
        $this->layout = 'MainLayout';
        $this->set('loadedModule','eventsTab');
        $this->render('/Modules/Events');
    }
    
    public function getEvents(){
        
        $response = $this->Event->find('all');
        
        return json_encode($response);
        
    }
    
    function getEventDonors(){
        if (empty($this->request->query['event_id'])){
            return json_encode(array('success'=>false,'message'=>'Event id empty'));
        }
        
        $result = $this->Event->find('first',[
            'conditions'=>['Event.id'=>$this->request->query['event_id']],
            'contain'=>['Donor']
        ]);
        
        return json_encode($result['Donor']);
       // debug($result['User']);
        
    }
    
    function addDonor(){
        if (empty($this->request->data['event_id']) || empty($this->request->data['donor_id'])){
            $response['success'] = false;
            $response['message'] = __('Please select a donor');
            return json_encode($response);
        }
        
        $saveData['EventMembership']['donor_id'] = $this->request->data['donor_id'];
        $saveData['EventMembership']['event_id'] = $this->request->data['event_id'];
        
        if($this->EventMembership->save($saveData)){
            $response['success'] = true;
            $response['message'] = '';
        } else {
            $response['success'] = false;
            $response['message'] = __('Error while saving. Please contact your Administrator.');
        }
        return json_encode($response);
    }
    
    function removeDonor(){
        if (empty($this->request->data['events_donors_id'])){
            $response['success'] = false;
            $response['message'] = __('Please select a donor');
            return json_encode($response);
        }
        
        if ($this->EventMembership->delete($this->request->data['events_donors_id'])){
            $response['success'] = true;
            $response['message'] = '';
        } else {
            $response['success'] = false;
            $response['message'] = __('Unable to delete'); 
        }
         return json_encode($response);
    }
    
    function edit(){
        if (empty($this->request->data)){
            $response['success'] = false;
            $response['message'] = 'Empty data sent!';
            return json_encode($response);
        }
        
        if (empty($this->request->data['Event_id'])){
            $this->Event->create();
        } else {
            $saveData['Event']['id'] = $this->request->data['Event_id'];
        }
        
        $saveData['Event']['title'] = trim($this->request->data['Event_title']);
        
        
        $start_time = date_create_from_format('d.m.Y',$this->request->data['Event_start_time']); 
        $saveData['Event']['start_time'] = $start_time->format('Y-m-d');
        
        $end_time = date_create_from_format('d.m.Y',$this->request->data['Event_end_time']); 
        $saveData['Event']['end_time'] = $end_time->format('Y-m-d');
        
        $saveData['Event']['user_id'] = AuthComponent::user('id');
        //to do
        // clinic_id
       
        if ($this->Event->saveAll($saveData)){
            $response['success'] = true;
            $response['message'] = __('Event successfully saved.');
        } else {
            $response['success'] = false;
            $response['message'] = __('Error while saving. Please contact your Administrator.');

        }
    
        return json_encode($response);
  
        
    }
    
    function delete(){
        if (empty($this->request->data['event_id'])){
            $response['success'] = false;
            $response['message'] = 'Empty id sent!';
            return json_encode($response);
        }
       
        if ($this->Event->delete($this->request->data['event_id'])){
            $response['success'] = true;
            $response['message'] = 'Yessss! Gone!';
        } else {
           $response['success'] = false;
            $response['message'] = 'Error deleting competition.'; 
        }
        
        return json_encode($response);
    }
    
    function test(){
       $result =  $this->Event->find('all');
       
       debug($result);
    }
    
    function createEvent(){
        $this->layout = false;
        $this->autoRender = false;
        
        $this->Event->create();
        $data['Event']['title'] = $this->request->data['event_title'];
        $this->Event->save($data);
        
        $donor_ids = json_decode($this->request->data['donor_ids']);
        foreach($donor_ids as $id){
            $saveData['EventMembership']['event_id'] = $this->Event->id;
            $saveData['EventMembership']['donor_id'] = $id;
            $this->EventMembership->saveAll($saveData);
        }
        
       
        
        return $this->request->data['donor_ids'];
        
       // return json_encode($this->request->data['donor_ids']);
    }
}