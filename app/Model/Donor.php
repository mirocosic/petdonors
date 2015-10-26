<?php class Donor extends AppModel {
    
    public $hasMany = array('EventMembership');
    
    public $hasAndBelongsToMany = array(
        'Event'=>array(
            'className' => 'Event',
            'joinTable' => 'events_donors',
            'foreign_key' => 'donor_id',
            'associationForeignKey' => 'event_id',
            'unique'=>true
            
        )
    );
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

