<?php class AlliancesController extends AppController {
    
    var $uses = ['Alliance'];
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = false;
        $this->autoRender = false;
    }
    
      public function index(){
        
        $response = $this->Alliance->find('all');
        
        return json_encode($response);
        
    }
    
    function edit(){
        if (empty($this->request->data)){
            $response['success'] = false;
            $response['message'] = 'Empty data sent!';
            return json_encode($response);
        }
        
        if (empty($this->request->data['Alliance_id'])){
            $this->Alliance->create();
        } else {
            $saveData['Alliance']['id'] = $this->request->data['Alliance_id'];
        }
        
        $saveData['Alliance']['name'] = trim($this->request->data['Alliance_name']);
              
       
        if ($this->Alliance->saveAll($saveData)){
            $response['success'] = true;
            $response['message'] = __('Alliance successfully saved.');
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
       
        if ($this->Alliance->delete($this->request->data['event_id'])){
            $response['success'] = true;
            $response['message'] = 'Yessss! Gone!';
        } else {
           $response['success'] = false;
            $response['message'] = 'Error deleting competition.'; 
        }
        
        return json_encode($response);
    }
}