<?php class AdminController extends AppController {
    
   function index(){
       $this->layout = 'admin';
       $this->set('modules',
               'usersTab,
                clinicsTab,
                permissionsTab,
                competitionsTab,
                eventsTab,
                alliancesTab,');
        
   }
}