<?php class Clinic extends AppModel {
    
    public $hasMany = array('ClinicMembership');
    
    public $hasAndBelongsToMany = array(
        'User'=>array(
            'className' => 'User',
            'joinTable' => 'users_clinics',
            'foreign_key' => 'clinic_id',
            'associationForeignKey' => 'user_id',
            'unique'=>true
            
        )
    );
    
}