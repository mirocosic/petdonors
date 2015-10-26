<?php

App::uses('AppHelper', 'View/Helper');

class ScriptIncludeHelper extends AppHelper {
    
    public $helpers = array('Html');
    
    public function includeScriptFolder($folder=null){
        
        if(Configure::read('debug')>0){        
             $fileList=$this->dirToArray(JS."/".$folder);
            return($this->RecursiveScriptTag($fileList,$folder));       
        }else{
            $this->RecursiveMinifiedScriptFolderContent(JS."/".$folder);
        }
        
        
    }
    
    private function RecursiveScriptTag($item,$path="")
    {
        if(is_array($item)){
            foreach($item as $folder=>$row){
                if(is_array($row)){
                    $this->RecursiveScriptTag($row,$path."/".$folder);
                }else{
                    echo $this->Html->script($path.'/'.$row);
                }
            }
        }else{            
            echo $this->Html->script($path.'/'.$item);
        }
    }
    
    private function RecursiveMinifiedScriptFolderContent($path="")
    {
        
        $minifiedCode = Cache::read('minifiedUXScripts');
        
        if(!$minifiedCode){
            App::uses('File', 'Utility');
            App::uses('Folder', 'Utility');

            $dir = new Folder($path);
            $files = $dir->findRecursive('.*js');
            
            
            natsort($files);
            
            $fillScriptContents="";

            foreach($files as $path){
                $f=new File($path,false);


                $fillScriptContents.=$f->read(false,'r');
                
                //echo $fillScriptContents; die;
                $f->close();
            }

            $minifiedCode = \JShrink\Minifier::minify($fillScriptContents,array('flaggedComments' => false));

            Cache::write('minifiedUXScripts', $minifiedCode);
        }
                
        echo '<script type="text/javascript">'.$minifiedCode.'</script>';
    }
    
    private function dirToArray($dir) { 
   
        $result = array(); 

        $cdir = scandir($dir); 
        foreach ($cdir as $key => $value) 
        { 
           if (!in_array($value,array(".",".."))) 
           { 
              if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
              { 
                 $result[$value] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
              } 
              else 
              { 
                 $result[] = $value; 
              } 
           } 
        } 

        return $result; 
     }
}