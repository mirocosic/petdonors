<?php class EventMembership extends AppModel {
    
    public $useTable = 'events_donors';
   
    public $belongsTo = array(
        'Donor', 'Event'
    );
}