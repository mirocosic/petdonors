<?php class Event extends AppModel {
   
    public $hasMany = array('EventMembership');
    
    public $hasAndBelongsToMany = array(
        'Donor'=>array(
            'className' => 'Donor',
            'joinTable' => 'events_donors',
            'foreign_key' => 'event_id',
            'associationForeignKey' => 'donor_id',
            'unique'=>true
            
        )
    );
}