<?php class ModulesController extends AppController {
    
    function get($module = null){
        $this->layout = 'javascript';
        $this->autoRender = false;
        $this->render(str_replace('.js','', $module));
        
    }
}