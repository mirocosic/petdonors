<?php class CompetitionsController extends AppController {
    
    var $uses = ['Competition','CompetitionType'];
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = false;
        $this->autoRender = false;
    }
    
    public function index(){
        
        $response = $this->Competition->find('all');
        
        return json_encode($response);
        
    }
    
    function edit(){
        
       
        if (empty($this->request->data)){
            $response['success'] = false;
            $response['message'] = 'Empty data sent!';
            return json_encode($response);
        }
        
        if (empty($this->request->data['Competition_id'])){
            $this->Competition->create();
        } else {
            $saveData['Competition']['id'] = $this->request->data['Competition_id'];
        }
        
        $saveData['Competition']['title'] = trim($this->request->data['Competition_title']);
        $saveData['Competition']['type_id'] = $this->request->data['Competition_type'];
        
        $start_date = date_create_from_format('d.m.Y',$this->request->data['Competition_start_date']); 
        $saveData['Competition']['start_date'] = $start_date->format('Y-m-d');
        
        $end_date = date_create_from_format('d.m.Y',$this->request->data['Competition_end_date']); 
        $saveData['Competition']['end_date'] = $end_date->format('Y-m-d');
       
        if ($this->Competition->saveAll($saveData)){
            $response['success'] = true;
            $response['message'] = __('Competition successfully saved.');
        } else {
            $response['success'] = false;
            $response['message'] = __('Error while saving. Please contact your Administrator.');

        }
    
        return json_encode($response);
  
        
    }
    
    function delete(){
        if (empty($this->request->data['competition_id'])){
            $response['success'] = false;
            $response['message'] = 'Empty id sent!';
            return json_encode($response);
        }
       
        if ($this->Competition->delete($this->request->data['competition_id'])){
            $response['success'] = true;
            $response['message'] = 'Yessss! Gone!';
        } else {
           $response['success'] = false;
            $response['message'] = 'Error deleting competition.'; 
        }
        
        return json_encode($response);
    }
    
    function getCompetitionTypes(){
        
        $result = $this->CompetitionType->find('all');
        
        return json_encode($result);
    }
    
    function getCompetitionEvents(){
        if (empty($this->request->query['competition_id'])){
            return json_encode(array('success'=>false,'message'=>'Competition id empty'));
        }
        
        $result = $this->Competition->find('first',[
            'conditions'=>['Competition.id'=>$this->request->query['competition_id']],
            'contain'=>['Event']
        ]);
        
        return json_encode($result['Event']);
    }
}