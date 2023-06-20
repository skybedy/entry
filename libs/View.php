<?php

class View{
    
    function __construct(){
        //echo 'This is View<br />';
    }
    
    public function Render($name,$noInclude = false){
        if($noInclude == true){
            require 'views/'.$name.'.php';
        }
        else{
            require 'views/header.php';
            require 'views/'.$name.'.php';
            require 'views/footer.php';
        
        }
    }
}