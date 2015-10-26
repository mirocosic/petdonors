<?php class ClinicMembership extends AppModel {
    
    public $useTable = 'users_clinics';
   
    public $belongsTo = array(
        'User', 'Clinic'
    );
}